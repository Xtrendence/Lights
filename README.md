# Lights

 A web interface along with a PHP-based API to interact with Yeelight smart bulbs.
 
### API Documentation

|Method|Endpoint          |Data|Description|
|------|------------------|----|-----------|
|GET   |get-brightness.php|N/A |Returns the brightness of the lightbulb|
|GET   |get-color.php     |N/A |Returns the color of the lightbulb|
|GET   |get-config.php    |N/A |Returns the IP, port, and guest mode setting|
|GET   |get-power.php     |N/A |Returns the power status of the lightbulb|
|GET   |get-status.php    |N/A |Returns the power status, brightness, color, and color mode of the lightbulb|
|POST   |set-brightness.php|{brightness} (int) (1 - 100)|Sets the brightness of the lightbulb|
|POST   |set-color.php     |{color} (string) (orange, white, purple, green, blue, red), {mode} (string) (color, bright)|Sets the color of the lightbulb|
|POST   |set-config.php    |{ip} (string), {port} (string), {guest-mode} (boolean)|Sets the IP, port, and guest mode setting|
|POST   |set-power.php     |{power} (boolean)|Sets the power status of the lightbulb|

![Web UI](https://i.imgur.com/j29SPea.png)
