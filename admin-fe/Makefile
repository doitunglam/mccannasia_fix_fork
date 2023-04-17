ifndef u
u:=root
endif

deploy:
	rsync -avhzL --delete \
				--no-perms --no-owner --no-group \
				--exclude .idea \
				--exclude .git \
				--exclude .next \
				--exclude node_modules \
				--exclude .husky \
				--exclude .env \
				--exclude .env.local \
				--exclude .history \
				--exclude Makefile \
				--exclude backend \
				. $(u)@$(h):$(dir)

deploy-dev: 
	make deploy h=128.199.145.119 dir=/home/mcc/vue