# Matrix Multiplier
A nanoservice built with Lumen

## Quick Start
- `git clone . . .`
- add line to etc/hosts, serve it up - I used Homestead :)
- `composer install`
- test api call (however you wish!)
    
    _Example provided with bash script:_ `apitest.sh`
    ```
    #!/bin/bash
    
    curl \
      --header "Content-type: application/json" \
      --request POST \
      --data '{"matrices":"[[[1,2,3],[4,5,6]],[[7,8],[9,10],[11,12]]]"}' \
      http://mm.loc/api/try
    
    printf "\n"
    ```
    _Response_
    ```
    $ ./apitest.sh
    {"product":[["BF","BL"],["EI","EX"]]}
    ```
