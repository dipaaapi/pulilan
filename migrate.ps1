$files = Get-ChildItem -Path "c:\Users\User\.gemini\antigravity-ide\scratch\pulilan" -Filter *.php -Recurse

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw

    $originalContent = $content

    # Panels to Cards
    $content = $content -replace 'panel panel-default', 'card'
    $content = $content -replace 'panel panel-primary', 'card bg-primary text-white'
    $content = $content -replace 'panel panel-success', 'card bg-success text-white'
    $content = $content -replace 'panel panel-info', 'card bg-info text-white'
    $content = $content -replace 'panel panel-warning', 'card bg-warning text-dark'
    $content = $content -replace 'panel panel-danger', 'card bg-danger text-white'
    
    $content = $content -replace 'panel-heading', 'card-header'
    $content = $content -replace 'panel-body', 'card-body'
    $content = $content -replace 'panel-footer', 'card-footer'
    $content = $content -replace 'panel-title', 'card-title'
    $content = $content -replace 'login-panel', 'login-card' # Assuming custom css might use this, but better to change it

    # Grid System offsets
    $content = $content -replace 'col-xs-offset-(\d+)', 'offset-$1'
    $content = $content -replace 'col-sm-offset-(\d+)', 'offset-sm-$1'
    $content = $content -replace 'col-md-offset-(\d+)', 'offset-md-$1'
    $content = $content -replace 'col-lg-offset-(\d+)', 'offset-lg-$1'

    # Grid System xs to nothing
    $content = $content -replace 'col-xs-(\d+)', 'col-$1'

    # Utilities
    $content = $content -replace 'pull-right', 'float-end'
    $content = $content -replace 'pull-left', 'float-start'
    
    # Images
    $content = $content -replace 'img-responsive', 'img-fluid'
    
    # Forms (Basic replacements)
    # Note: control-label doesn't map perfectly without modifying the DOM structure, but form-label is the new class
    $content = $content -replace 'control-label', 'form-label'

    if ($originalContent -cne $content) {
        Set-Content -Path $file.FullName -Value $content -NoNewline
        Write-Host "Updated $($file.Name)"
    }
}
Write-Host "Migration script completed."
