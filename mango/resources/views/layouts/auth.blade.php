<!--
=========================================================
* Soft UI Dashboard - v1.0.7
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/svg+xml" href="/logo.svg">
    <title>
        Mangosteen | containers watcher dashboard
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
    <link href="/css/custom.css" rel="stylesheet" />
    <link href="/vend/toastify/toastify.css" rel="stylesheet" />
</head>

<body class="">

    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid pe-0">
                        <span class="navbar-brand font-weight-bolder ms-lg-0 ms-3 text-info text-gradient">
                            Mangosteen
                        </span>
                        <div class="collapse navbar-collapse" id="navigation">
                            <ul class="navbar-nav mx-auto">
                                <li class="nav-item">
                                    <a href="https://github.com/Cherry-Pie/Mangosteen" target="_blank" class="text-dark me-xl-4 me-4">
                                        <span class="text-lg fab fa-github"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
        </div>
    </div>

    <main class="main-content  mt-0">
        {{ $slot }}
    </main>

    <script src="/vend/toastify/toastify.js" type="text/javascript" charset="utf-8"></script>

    <script data-navigate-once>
        document.addEventListener('alpine:init', () => {
            let state = Alpine.reactive({ path: window.location.pathname })

            document.addEventListener('livewire:navigated', () => {
                queueMicrotask(() => {
                    state.path = window.location.pathname
                })
            })

            Alpine.magic('current', (el) => (expected = '') => {
                let strip = (subject) => subject.replace(/^\/|\/$/g, '')
                return strip(state.path) === strip(expected)
            })
        })

        document.addEventListener('livewire:init', () => {
            Livewire.on('toastify', (event) => {
                const options = {
                    text: event[0].text,
                    duration: 123000,
                }
                if (event[0].type === 'danger') {
                    options.style = {
                        background: "linear-gradient(to right, rgb(255, 95, 109), rgb(255, 195, 113))",
                    }
                }
                Toastify(options).showToast();
            });
        });
    </script>
</body>

</html>
