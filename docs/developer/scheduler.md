# Horizon
Horizon spawns workers which consume jobs. It does NOT generate jobs.

# Scheduler
The Scheduler runs Scheduled Tasks at a specific time. These Tasks can do a bunch of things, but I use to it spawn Jobs.
The Scheduler is triggered from Crontab

# Thumbnails
Run `node node_modules/puppeteer/install.js` to have puppeteer download Chrome. If you don't do this - it will not work.
