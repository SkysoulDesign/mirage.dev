@servers(['web' => 'root@cms.soapstudio.com])

@task('git')
    cd /home/mirage.dev/
    git checkout .
    git pull
@endtask