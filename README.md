<p align="center">
    <h1 align="center">Test work to FOM GROUP</h1>
</p>

1. First you should git clone
2. You shuold create .env file: just copy from .env.exapmle or run command 
   ``php init`` it creat .env file
    ```
    NOTE: 80 and 5432 port must not be busy 
   ```
3. run docker
   ```
    docker compose up -d
   ```
4. run migrations
    ```
     docker container exec ph_php php ./pharmacy/yii migrate --interactive=0
   ```
5. open browser
   ```
   http://localhost/
   ```


Upload xml files
-------------------
you can upload it from main page of site
and if you want upload big file or more than one file
you should put files to ``~{project-folder}/xml/tmp/`` and run command
   ```
   docker container exec ph_php php ./pharmacy/yii templates
   ```

If something is wrong you can text to me
-------------------
https://t.me/Salikhov_ID
