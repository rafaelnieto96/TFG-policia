# Stage 1: Build the application
FROM php:7.4-fpm-buster AS builder

# Install dependencies needed for Symfony and the application
RUN apt-get update && \
    apt-get install -y git unzip libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql && \
    pecl install apcu && \
    docker-php-ext-enable apcu && \
    rm -rf /var/lib/apt/lists/*

# Set the working directory
WORKDIR /var/www/html

# Copy the application files into the container
COPY . .

# Install the Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --no-scripts --optimize-autoloader

# Stage 2: Run the optimized application
FROM php:7.4-fpm-buster

# Install dependencies needed for the optimized application
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql && \
    rm -rf /var/lib/apt/lists/*

# Set the working directory
WORKDIR /var/www/html

# Copy the application files from the builder stage
COPY --from=builder /var/www/html .

# Install the Symfony CLI
RUN apt-get update && \
    apt-get install -y wget && \
    wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony && \
    apt-get remove -y wget && \
    rm -rf /var/lib/apt/lists/*

# Expose the port the application will be running on
EXPOSE 8000

# Start the application
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]