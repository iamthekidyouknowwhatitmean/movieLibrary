<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie Library</title>
    @vite("resources/css/app.css")
    @vite("resources/js/app.js")
</head>
<body class="bg-gray-600 text-white">
    <header class="bg-gray-900">
        <nav aria-label="Global" class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8">
            <div class="flex lg:flex-1">
                <a href="/" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="" class="h-8 w-auto" />
                </a>
            </div>
           
            <el-popover-group class="hidden lg:flex lg:gap-x-12">
                <a href="/films" class="text-sm/6 font-semibold text-white">Films</a>
            </el-popover-group>
            @guest
                <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-5">
                    <a href="/register" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-white/5">Create Account</a>
                    <a href="/login" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-white/5">Log in</a>
                </div>    
            @endguest
            
            @auth
                <select name="" id="" onchange="this.form.submit()">
                    <option value="">-- выберите страницу --</option>
                    <option value="/settings">Settings</option>
                </select>
                <form action="/logout" method="POST">
                    @csrf
                    <button>Log Out</button>
                </form>
            @endauth
            
        </nav>
    </header>

    {{ $slot }}
</body>
</html>
