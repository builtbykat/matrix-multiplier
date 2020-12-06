# Matrix Multiplier
A nanoservice built with Lumen

## Quick Start
- `git clone . . .`
- add hostname, add line to etc/hosts, serve it up - I used Homestead :)
- `composer install`
- make `POST` call to `http://{your-assigned-hostname}/api/try`
    
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

##### Notes
There is a lot of room for human error building out the `matrices` request body, maybe each matrix is better passed as `{"matrix1":"[...]", "matrix2":"[...]"}`
