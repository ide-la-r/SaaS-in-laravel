# Deployment Checklist for TaskFlow

## Pre-Deployment

- [ ] All tests passing: `./vendor/bin/sail pest`
- [ ] No security vulnerabilities: `composer audit`
- [ ] Environment variables configured in `.env.production`
- [ ] Database migrations tested locally
- [ ] Stripe keys (live) configured
- [ ] Email sender configured
- [ ] HTTPS certificate ready

## Deployment Steps (Laravel Forge / Railway / Your Provider)

1. **Clone repository:**
   ```bash
   git clone https://github.com/ide-la-r/SaaS-in-laravel.git
   cd SaaS-in-laravel
   ```

2. **Install dependencies:**
   ```bash
   composer install --no-dev --optimize-autoloader
   npm install && npm run build
   ```

3. **Configure environment:**
   ```bash
   cp .env.production .env
   ```

4. **Generate app key:**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations:**
   ```bash
   php artisan migrate --force
   php artisan db:seed --class=PlanSeeder
   ```

6. **Optimize:**
   ```bash
   bash scripts/optimize.sh
   ```

7. **Set permissions:**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

8. **Restart queue workers:**
   ```bash
   php artisan queue:restart
   ```

## Post-Deployment

- [ ] Test login flow
- [ ] Verify Stripe integration
- [ ] Check email sending
- [ ] Monitor error logs
- [ ] Load test (siege/wrk)
- [ ] SSL certificate valid

## Monitoring

Set up monitoring for:
- Application errors (Laravel Telescope or Sentry)
- Database performance
- Redis memory usage
- Queue jobs
- Stripe webhooks

## Scaling

If you outgrow single server:
1. Separate database to managed RDS/PostgreSQL
2. Use separate Redis instance
3. Add load balancer
4. Set up CDN for static assets
5. Use queue workers for async jobs
