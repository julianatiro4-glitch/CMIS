<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - QC PESO CMIS</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center" style="background:linear-gradient(135deg,#091d42 0%,#0d2a5e 60%,#1a1a4e 100%);">

<div class="w-full max-w-sm mx-4">

    <div class="text-center mb-6">
        <img src="/images/logo.png" alt="QC PESO"
             class="w-20 h-20 rounded-full mx-auto bg-white p-1 shadow-lg object-contain">
        <h1 class="text-white font-bold text-lg mt-3">QC PESO CMIS</h1>
        <p class="text-blue-300 text-xs">Computer Management Inventory System</p>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl p-8">

        <h2 class="text-xl font-bold text-slate-800 mb-1">Welcome back</h2>
        <p class="text-slate-400 text-sm mb-6">Sign in to access the system</p>

        <?php if(session('status')): ?>
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
                <?php echo e($message); ?>

            </div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                    Email Address
                </label>
                <input type="email" name="email"
                       value="<?php echo e(old('email')); ?>"
                       autofocus
                       placeholder="you@example.com"
                       class="w-full border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-5">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                    Password
                </label>
                <div class="relative">
                    <input type="password" name="password"
                           id="pwd"
                           placeholder="Enter password"
                           class="w-full border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 pr-16">
                    <button type="button" id="togglePwd"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-blue-600 hover:text-blue-800">
                        Show
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-2 mb-5">
                <input type="checkbox" name="remember" id="rem"
                       class="w-4 h-4 rounded border-slate-300">
                <label for="rem" class="text-sm text-slate-500 cursor-pointer">Remember me</label>
            </div>

            <button type="submit"
                    class="w-full text-white font-bold py-3 rounded-lg text-sm hover:opacity-90 shadow-md transition-all"
                    style="background:linear-gradient(135deg,#091d42,#1a3a7c);">
                Sign In
            </button>

        </form>


    </div>
</div>

<script>
    var btn = document.getElementById('togglePwd');
    var pwd = document.getElementById('pwd');
    btn.addEventListener('click', function() {
        var show = pwd.type === 'password';
        pwd.type = show ? 'text' : 'password';
        btn.textContent = show ? 'Hide' : 'Show';
    });
</script>

</body>
</html><?php /**PATH C:\Users\JulianaTiro\cmis\resources\views/auth/login.blade.php ENDPATH**/ ?>