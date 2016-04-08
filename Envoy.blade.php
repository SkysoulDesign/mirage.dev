@servers(['web' => 'root@cms.soapstudio.com'])

@task('git')
    cd /home/mirage.dev/
    git pull
@endtask

@task('composer')
    cd /home/mirage.dev/
    composer update
@endtask

@task('refresh')
    cd /home/mirage.dev/
    php artisan migrate:refresh --seed
@endtask

@task('admin')
    sudo apt-get install phpmyadmin
@endtask

@task('fixpermission')
    cd /home/mirage.dev/
    sudo chmod -R 777 image
    sudo chmod -R 777 storage
    sudo chmod -R 777 bootstrap/cache
@endtask