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
    // Session timeout handler
    document.addEventListener('DOMContentLoaded', function() {
        // Reset activity timer on user interaction
        function resetActivityTimer() {
            // Send AJAX request to update session
            fetch('update_session_activity.php', {
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

        // Activity events
        const events = ['mousemove', 'keydown', 'click', 'scroll', 'touchstart'];
        events.forEach(event => {
            document.addEventListener(event, resetActivityTimer, {
                passive: true
            });
        });

        // Show session timer if element exists
        function updateSessionTimer() {
            const timerEl = document.getElementById('sessionTimer');
            if (timerEl) {
                // Calculate remaining time (simplified)
                const remaining = 120; // 2 minutes
                const minutes = Math.floor(remaining / 60);
                const seconds = remaining % 60;
                timerEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
        }

        // Update timer every second
        setInterval(updateSessionTimer, 1000);
        updateSessionTimer();
    });
</script>





</body>

</html>