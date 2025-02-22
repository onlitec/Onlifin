<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name')); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="<?php echo e(route('dashboard')); ?>" class="text-xl font-bold text-gray-800">
                                <?php echo e(config('app.name')); ?>

                            </a>
                        </div>

                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="<?php echo e(route('dashboard')); ?>" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 <?php echo e(request()->routeIs('dashboard') ? 'border-indigo-400' : 'border-transparent'); ?> text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                                Dashboard
                            </a>
                            <a href="<?php echo e(route('expenses.index')); ?>" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 <?php echo e(request()->routeIs('expenses.*') ? 'border-indigo-400' : 'border-transparent'); ?> text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                Despesas
                            </a>
                            <a href="<?php echo e(route('incomes.index')); ?>" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 <?php echo e(request()->routeIs('incomes.*') ? 'border-indigo-400' : 'border-transparent'); ?> text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                Receitas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <?php echo e($slot); ?>

        </main>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html><?php /**PATH /var/www/html/onlifin/resources/views/components/layouts/app.blade.php ENDPATH**/ ?>