<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>VibeLines</title>
</head>
<body class="{{ request()->is('admin/*') ? 'admin-page' : '' }}">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">VibeLines</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('quotes.create') }}">Submit Quote</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.quotes.index') }}">Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <main id="main_content_container" style="min-height: 100vh;" class="py-4">
        @yield('content')
    </main>

    <script>
        function generatePastelColor(baseColor = null, blendAmount = 0.7) {
            // baseColor should be in the form of a hex value like "#RRGGBB"
            let r, g, b;
            if (!baseColor) {
                // Generate a random base color
                r = Math.floor(Math.random() * 256); // 0-255 range
                g = Math.floor(Math.random() * 256);
                b = Math.floor(Math.random() * 256);
            } else {
                r = parseInt(baseColor.slice(1, 3), 16);
                g = parseInt(baseColor.slice(3, 5), 16);
                b = parseInt(baseColor.slice(5, 7), 16);
            }

            // Blending the base color with white (255, 255, 255)
            r = Math.round(r + (255 - r) * blendAmount);
            g = Math.round(g + (255 - g) * blendAmount);
            b = Math.round(b + (255 - b) * blendAmount);

            // Return the new pastel color as a hex code
            return `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
        }

        // Function to change the background color
        function changeBackgroundColor() {
            if (document.body.classList.contains('admin-page')) {
                return; // Don't change the background color on admin pages
            }
            const randomPastelColor = generatePastelColor();
            console.log('randomPastelColor', randomPastelColor);

            document.getElementById('main_content_container').style.backgroundColor = randomPastelColor;
        }

        // Call changeBackgroundColor on page load and whenever a new quote is shown
        changeBackgroundColor();


    </script>


    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>