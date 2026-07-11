<?php
$page_title = 'Manage Blog';
$page_header = 'Latest News & Blog';
require_once 'admin_header.php';
require_once 'upload_widget.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$success_message = '';
$error_message = '';

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_post'])) {
        $title    = trim($_POST['title']);
        $category = trim($_POST['category']);
        $excerpt  = trim($_POST['excerpt']);
        $content  = trim($_POST['content']);
        $image    = trim($_POST['image']); // Cloudinary URL

        if (empty($title) || empty($content) || empty($category)) {
            $error_message = 'Title, Category, and Content are required fields.';
        } else {
            try {
                if ($id > 0) {
                    $stmt = $pdo->prepare("UPDATE `blog_posts` SET `title` = :title, `category` = :category, `excerpt` = :excerpt, `content` = :content, `image` = :image WHERE `id` = :id");
                    $stmt->execute([
                        'title'    => $title,
                        'category' => $category,
                        'excerpt'  => $excerpt,
                        'content'  => $content,
                        'image'    => $image,
                        'id'       => $id
                    ]);
                    $success_message = 'Blog post updated successfully.';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO `blog_posts` (`title`, `category`, `excerpt`, `content`, `image`) VALUES (:title, :category, :excerpt, :content, :image)");
                    $stmt->execute([
                        'title'    => $title,
                        'category' => $category,
                        'excerpt'  => $excerpt,
                        'content'  => $content,
                        'image'    => $image
                    ]);
                    $success_message = 'New blog post published successfully.';
                }
                $action = 'list';
            } catch (PDOException $e) {
                $error_message = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

// Handle Delete
if ($action === 'delete' && $id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM `blog_posts` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $success_message = 'Blog post deleted successfully.';
        $action = 'list';
    } catch (PDOException $e) {
        $error_message = 'Failed to delete blog post: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch single post for edit
$post = null;
if ($action === 'edit' && $id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM `blog_posts` WHERE `id` = :id");
        $stmt->execute(['id' => $id]);
        $post = $stmt->fetch();
        if (!$post) {
            $error_message = 'Blog post not found.';
            $action = 'list';
        }
    } catch (PDOException $e) {
        $error_message = 'Database error: ' . $e->getMessage();
        $action = 'list';
    }
}

// Fetch all posts
$posts = [];
if ($action === 'list') {
    try {
        $posts = $pdo->query("SELECT * FROM `blog_posts` ORDER BY `created_at` DESC, `id` DESC")->fetchAll();
    } catch (PDOException $e) {
        $error_message = 'Failed to retrieve blog posts: ' . $e->getMessage();
    }
}
?>

<?php if ($success_message): ?>
    <div class="alert alert-success">
        <strong>Success!</strong> <?php echo htmlspecialchars($success_message); ?>
    </div>
<?php endif; ?>

<?php if ($error_message): ?>
    <div class="alert alert-error">
        <strong>Error:</strong> <?php echo htmlspecialchars($error_message); ?>
    </div>
<?php endif; ?>

<?php if ($action === 'list'): ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Blog & News Posts</h3>
            <a href="blog.php?action=add" class="btn btn-primary">Add New Post +</a>
        </div>

        <?php if (empty($posts)): ?>
            <p style="font-size:13px; color:#64748b; text-align:center; padding: 24px 0;">No blog posts configured. Click 'Add New Post' to publish one.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 100px; text-align: center;">Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Published Date</th>
                            <th style="width: 160px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $p): ?>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">
                                    <?php if (!empty($p['image'])): ?>
                                        <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>" style="width: 60px; height: 45px; object-fit: cover; border-radius: 4px; border: 1px solid rgba(0,0,0,0.1);">
                                    <?php else: ?>
                                        <div style="width: 60px; height: 45px; background: #f1f5f9; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 16px;">📰</div>
                                    <?php endif; ?>
                                </td>
                                <td style="font-weight: 600; color: var(--maroon-900);">
                                    <?php echo htmlspecialchars($p['title']); ?>
                                </td>
                                <td>
                                    <span style="font-size: 12px; font-weight: 600; color: var(--gold-600);"><?php echo htmlspecialchars($p['category']); ?></span>
                                </td>
                                <td>
                                    <?php echo date('M d, Y', strtotime($p['created_at'])); ?>
                                </td>
                                <td style="text-align: right;">
                                    <a href="blog.php?action=edit&id=<?php echo $p['id']; ?>" class="btn btn-gold btn-sm">Edit</a>
                                    <a href="blog.php?action=delete&id=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this blog post?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

<?php elseif ($action === 'add' || $action === 'edit'): ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo ($action === 'edit') ? 'Edit Blog Post' : 'Publish New Blog Post'; ?></h3>
            <a href="blog.php" class="btn btn-secondary btn-sm">← Back to List</a>
        </div>

        <form action="blog.php<?php echo ($action === 'edit') ? '?id=' . $id : ''; ?>" method="POST">
            <input type="hidden" name="save_post" value="1">

            <div class="form-group">
                <label class="form-label" for="title">Article Title</label>
                <input type="text" id="title" name="title" class="form-input" required value="<?php echo ($post) ? htmlspecialchars($post['title']) : ''; ?>" placeholder="e.g. Disruptive Revenue & PMS Technology for 2026">
            </div>

            <div class="form-group">
                <label class="form-label" for="category">Category</label>
                <input type="text" id="category" name="category" class="form-input" required value="<?php echo ($post) ? htmlspecialchars($post['category']) : ''; ?>" placeholder="e.g. Operations, HR & Leadership, Sustainability">
            </div>

            <div class="form-group">
                <label class="form-label" for="excerpt">Short Description (Excerpt for homepage card)</label>
                <textarea id="excerpt" name="excerpt" class="form-textarea" required style="height: 80px;" placeholder="A brief 1-2 sentence summary shown in the card listings..."><?php echo ($post) ? htmlspecialchars($post['excerpt']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="content">Full Article Content</label>
                <textarea id="content" name="content" class="form-textarea" required style="height: 250px;" placeholder="Write the full body of the article here..."><?php echo ($post) ? htmlspecialchars($post['content']) : ''; ?></textarea>
            </div>

            <?php
            render_image_upload_widget([
                'field_name'  => 'image',
                'widget_id'   => 'blog',
                'current_url' => ($post && !empty($post['image'])) ? $post['image'] : '',
                'label'       => 'Featured Article Image',
                'optional'    => true
            ]);
            ?>

            <div style="margin-top: 24px; display: flex; gap: 12px; flex-wrap: wrap;">
                <button type="submit" class="btn btn-primary">Publish Post</button>
                <a href="blog.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
require_once 'admin_footer.php';
?>
