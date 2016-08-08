COMPOSER=composer --no-interaction --no-progress --optimize-autoloader

clean:
	rm -fr vendor/ node_modules/

node_modules:
	npm install

vendor:
	$(COMPOSER) install

local-settings:
	cp dev/local-settings-sample.php local-settings.php

bower_components: node_modules
	./node_modules/.bin/bower install

phpcs: vendor
	./vendor/bin/phpcs --extensions=php --standard=PSR2 -s src/

phpmd: vendor
	./vendor/bin/phpmd src/ text dev/standard/phpmd.xml

codestyle: phpcs phpmd

fixcodestyle: vendor
	./vendor/bin/phpcbf --extensions=php --standard=PSR2 -s src/

codestyle-hook:
	touch .git/hooks/pre-commit
	touch .git/hooks/post-merge
	echo make codestyle > .git/hooks/pre-commit
	echo make codestyle > .git/hooks/post-merge
	chmod +x .git/hooks/pre-commit .git/hooks/post-merge

generate-migrate: vendor
	./vendor/bin/doctrine migrations:diff

migrate: vendor
	./vendor/bin/doctrine migrations:migrate --no-interaction

generate-entities: vendor
	./vendor/bin/doctrine orm:convert-mapping --namespace="Entities\\" --force  --from-database annotation ./src/

schema-update:
	./vendor/bin/doctrine schema:update --force

apiDoc:
	mkdir -p dev/apiDocumentations
	chmod -R 777 dev/apiDocumentations
	apidoc -i src/ -o dev/apiDocumentations/
