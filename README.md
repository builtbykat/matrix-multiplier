# Matrix Multiplier
A nanoservice built with Lumen

## Quick Start
- `git clone . . .`
- add line to etc/hosts, serve it up - I used Homestead :)
- `composer install`
- test api call
    - use `http://{your-local-url}/api/try`
    - add request body -- json with property "matrices" that has an array with two nested arrays, where matrix1's columns == matrix2's rows
      ```
      {"matrices":"[[[1,2,3],[4,5,6]],[[7,8],[9,10],[11,12]]]"}

