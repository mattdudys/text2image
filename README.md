# text2image

This is a simple web service that converts the HTTP path into a dynamic png image.

In my case I was debugging email client behavior for img tags with URLs at http and https URLs with various caching and redirect behavior.

ngrok serves both http and https on the same port.

```
# Build the Docker image
$ docker build -t text2image .

# Start ngrok on port 56123
$ ngrok http 56123

# Generate some URLs
# Update generate-urls.php with your new ngrok domain name.
$ php generate-urls.php

# Run it
$ docker run -it --rm -p 56123:80 --name text2image text2image:latest

# Test it out by changing the HTTP path!```

The script that generates the image is in `www/index.php`. All requests are handled by it.

## Caching

If `cache` appears in the path it will send `Cache-Control` headers to cache the image for 60 seconds. If the browser sends caching headers like `If-Modified-Since` and `If-None-Match` it should reply back with a `304 Not Modified` response.

If `cache` does not appear in the URL a `Cache-Control: no-cache, no-store` instructs the browser not to cache it.

## Redirects

If `redirect/` appears in the path it will do a 302 redirect to the path without `redirect/`. So `/foo/redirect/bar?k=v` would redirect to `/foo/bar?k=v`.
