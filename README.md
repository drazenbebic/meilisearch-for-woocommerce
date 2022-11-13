# Meilisearch for WooCommerce

Enterprise level search engine directly integrated into WooCommerce.

### Installation

1. Install the plugin.
2. Add Meilisearch instance URL & API key into settings.

### Setting up Meilisearch (Docker)

1. Pull the latest meilisearch image
   with `docker pull getmeili/meilisearch:v0.29`
3. Run the container
   with `docker run -d --name meilisearch --restart=always -p 7700:7700 -e MEILI_MASTER_KEY="MASTER_KEY" getmeili/meilisearch:v0.29`

## Setting up the WordPress development environment

1. Run `docker-compose up` in the root folder.
2. Open `http://127.0.0.1` in your browser and set up the WordPress instance. 

Replace `MASTER_KEY` with your master key in step 2.