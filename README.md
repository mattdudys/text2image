# text2image

This is a simple web service that converts the HTTP path into a png image that you can use to generate dynamic images.

In my case I was debugging email client behavior for img tags with URLs at http and https URLs.

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

# Test it out by changing the HTTP path!
```
