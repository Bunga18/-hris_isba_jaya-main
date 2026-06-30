<?php
    // Read Vite manifest to find the correct hashed filenames
    $manifestPath = public_path('dist/manifest.json');
    $manifest = json_decode(file_get_contents($manifestPath), true);

    $cssFile  = $manifest['resources/css/app.css']['file'] ?? null;
    $jsFile   = $manifest['resources/js/app.js']['file']  ?? null;

    // Read the CSS content to inline it (bypass InfinityFree 403 on .css files)
    $cssContent = '';
    if ($cssFile && file_exists(public_path("dist/{$cssFile}"))) {
        $cssContent = file_get_contents(public_path("dist/{$cssFile}"));
    }
?>


<?php if($cssContent): ?>
<style><?php echo $cssContent; ?></style>
<?php endif; ?>


<?php if($jsFile): ?>
<script src="<?php echo e(asset("dist/{$jsFile}")); ?>" defer></script>
<?php endif; ?>
<?php /**PATH D:\hris_isba_jaya-main\resources\views/components/vite-assets.blade.php ENDPATH**/ ?>