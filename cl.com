server {

	## Only allow these request methods ##
	if ($request_method !~ ^(GET|HEAD|POST)$ ) {
        	return 444;
     	}

    	listen 80;
    	server_name www.cl.com;
            
        access_log /var/log/nginx/champions-league/champions-league.log;
        error_log   /var/log/nginx/champions-league/champions-league.log warn;

	## Default location
    	location / {
		root   /var/www/champions-league;
          	index  index.php;
                charset	utf-8;

   		if (-f $request_filename) {
                	break;
                }
                
	        if (!-f $request_filename) {
                	rewrite ^/(.*)$ /index.php last;
                        break;
   		}

		## All other errors get the generic error page
      		## error_page 400 401 402 403 404 405 406 407 408 409 410 411 412 413 414 415 416 417 /error_page.html;
      		## error_page 500 501 502 503 504 505 /error_page_500.html;


		## Parse all .php file in the directory
    		location ~ \.php$ {

       			fastcgi_split_path_info ^(.+\.php)(.*)$;

        		fastcgi_pass   127.0.0.1:9000;
        		fastcgi_index  index.php;

        		fastcgi_param  SCRIPT_FILENAME  /home/onur/workspace-php/sirketcev6/$fastcgi_script_name;
        

       	 		include fastcgi_params;
        		fastcgi_param  QUERY_STRING     $query_string;
        		fastcgi_param  REQUEST_METHOD   $request_method;
        		fastcgi_param  CONTENT_TYPE     $content_type;
        		fastcgi_param  CONTENT_LENGTH   $content_length;
        		fastcgi_intercept_errors        on;
        		fastcgi_ignore_client_abort     off;
        		fastcgi_connect_timeout 60;
        		fastcgi_send_timeout 180;
        		fastcgi_read_timeout 180;
        		fastcgi_buffer_size 128k;
        		fastcgi_buffers 4 256k;
        		fastcgi_busy_buffers_size 256k;
        		fastcgi_temp_file_write_size 256k;

			fastcgi_param  SCRIPT_FILENAME    $document_root$fastcgi_script_name;
			fastcgi_param  SCRIPT_NAME        $fastcgi_script_name;
			fastcgi_param  REQUEST_URI        $request_uri;
			fastcgi_param  DOCUMENT_URI       $document_uri;
			fastcgi_param  DOCUMENT_ROOT      $document_root;
			fastcgi_param  SERVER_PROTOCOL    $server_protocol;
			fastcgi_param  GATEWAY_INTERFACE  CGI/1.1;
			fastcgi_param  SERVER_SOFTWARE    nginx;
			fastcgi_param  REMOTE_ADDR        $remote_addr;
			fastcgi_param  REMOTE_PORT        $remote_port;
			fastcgi_param  SERVER_ADDR        $server_addr;
			fastcgi_param  SERVER_PORT        $server_port;
			fastcgi_param  SERVER_NAME        $server_name;
			fastcgi_param  REDIRECT_STATUS    200;



    		}

		## Disable viewing .htaccess & .htpassword
		location ~ /\.ht {
        		deny  all;
    		}
	}

}

