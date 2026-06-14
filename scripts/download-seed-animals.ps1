$dest = Join-Path $PSScriptRoot "..\public\images\seed\animals"
New-Item -ItemType Directory -Force -Path $dest | Out-Null

function Save-Image($url, $path) {
    Invoke-WebRequest -Uri $url -OutFile $path -UseBasicParsing
}

# 35 psow (dog.ceo)
for ($i = 1; $i -le 35; $i++) {
    $num = "{0:D3}" -f $i
    $out = Join-Path $dest "$num.jpg"
    if (Test-Path $out) { continue }
    $resp = Invoke-RestMethod "https://dog.ceo/api/breeds/image/random"
    Save-Image $resp.message $out
    Write-Host "dog $num"
    Start-Sleep -Milliseconds 300
}

# 12 kotow (cataas)
for ($i = 36; $i -le 47; $i++) {
    $num = "{0:D3}" -f $i
    $out = Join-Path $dest "$num.jpg"
    if (Test-Path $out) { continue }
    Save-Image "https://cataas.com/cat?width=600&height=400&_=$i" $out
    Write-Host "cat $num"
    Start-Sleep -Milliseconds 400
}

# 3 kroliki (unsplash + zapas z dog.ceo jesli 404)
$rabbitUrls = @(
    "https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?w=600&h=400&fit=crop"
)
for ($j = 0; $j -lt 3; $j++) {
    $i = 48 + $j
    $num = "{0:D3}" -f $i
    $out = Join-Path $dest "$num.jpg"
    if (Test-Path $out) { continue }
    try {
        if ($j -eq 0) {
            Save-Image $rabbitUrls[0] $out
        } else {
            $resp = Invoke-RestMethod "https://dog.ceo/api/breeds/image/random"
            Save-Image $resp.message $out
        }
    } catch {
        $resp = Invoke-RestMethod "https://dog.ceo/api/breeds/image/random"
        Save-Image $resp.message $out
    }
    Write-Host "rabbit $num"
}

Write-Host "Done. Files: $((Get-ChildItem $dest -Filter *.jpg).Count)"
