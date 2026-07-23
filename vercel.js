{
  "functions": {
    "*.php": {
      "runtime": "vercel-php@0.9.0"
    },
    "backend/*.php": {
      "runtime": "vercel-php@0.9.0"
    },
    "backend/includes/*.php": {
      "runtime": "vercel-php@0.9.0"
    }
  },
  "routes": [
    { "src": "/$", "dest": "/index.php" },
    { "src": "/(.*)", "dest": "/$1" }
  ]
}
