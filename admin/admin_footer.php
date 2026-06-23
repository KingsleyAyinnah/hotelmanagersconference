        </main>
    </div>

    <script>
        // Sidebar responsive hamburger trigger
        var hamburger = document.getElementById('adminHamburger');
        var sidebar = document.getElementById('adminSidebar');
        
        if (hamburger && sidebar) {
            hamburger.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.toggle('active');
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 1024) {
                    var isClickInsideSidebar = sidebar.contains(e.target);
                    var isClickInsideHamburger = hamburger.contains(e.target);
                    
                    if (!isClickInsideSidebar && !isClickInsideHamburger && sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                    }
                }
            });
        }
    </script>
</body>
</html>
