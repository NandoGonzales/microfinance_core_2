<!-- footer.php -->
</div> <!-- end row -->
</div> <!-- end container-fluid -->

<!-- Booststrap 5! jS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Sweet aleart JS and CSS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- AJAX links -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Session timeout handler with SweetAlert
    document.addEventListener('DOMContentLoaded', function() {
        let sessionTimeout = 120; // 2 minutes in seconds
        let warningTime = 30; // Show warning at 30 seconds
        let countdownInterval;
        let lastActivity = Date.now();

        // Reset activity timer on user interaction
        function resetActivityTimer() {
            lastActivity = Date.now();
            
            // Send AJAX request to update session (ABSOLUTE PATH)
            fetch('/admin/inc/update_session_activity.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'update_activity'
                })
            }).catch(() => {
                // Silently fail if server not reachable
            });
        }

        // Check session timeout
        function checkSessionTimeout() {
            const elapsed = Math.floor((Date.now() - lastActivity) / 1000);
            const remaining = sessionTimeout - elapsed;

            if (remaining <= 0) {
                // Session expired - show SweetAlert
                clearInterval(countdownInterval);
                
                Swal.fire({
                    icon: 'warning',
                    title: 'Session Expired',
                    html: '<p style="color: #856404; font-weight: bold; font-size: 1rem; margin: 10px 0;">You have been logged out due to 2 minutes of inactivity.</p><p style="color: #6c757d; font-size: 0.95rem; margin: 10px 0;">Please log in again to continue.</p>',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                    allowOutsideClick: false,
                    background: '#ffffff'
                }).then(() => {
                    window.location.href = '/admin/login.php';
                });
            }
        }

        // Activity events
        const events = ['mousemove', 'keydown', 'click', 'scroll', 'touchstart'];
        events.forEach(event => {
            document.addEventListener(event, resetActivityTimer, {
                passive: true
            });
        });

        // Check every second
        countdownInterval = setInterval(checkSessionTimeout, 1000);

        // Initial activity
        resetActivityTimer();
    });
</script>

</body>
</html>