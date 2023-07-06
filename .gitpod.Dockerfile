FROM gitpod/workspace-full

USER root

COPY start-php.sh /usr/local/bin/start-php.sh
RUN chmod +x /usr/local/bin/start-php.sh

CMD ["/usr/local/bin/start-php.sh"]