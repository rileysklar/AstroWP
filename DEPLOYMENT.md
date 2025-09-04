# AstroWP Deployment Guide

## Overview
This project is configured for deployment with:
- **Frontend**: Astro site deployed on Netlify
- **Backend**: WordPress deployed on Google Cloud Run
- **Database**: Cloud SQL (MySQL/PostgreSQL)

## Prerequisites

### Google Cloud Setup
1. Create a Google Cloud Project
2. Enable required APIs:
   - Cloud Run API
   - Cloud SQL Admin API
   - Container Registry API
3. Create a service account with necessary permissions
4. Set up Cloud SQL instance

### Netlify Setup
1. Create a Netlify account
2. Connect your GitHub repository
3. Get your site ID and auth token

## Environment Variables

### GitHub Secrets (for GitHub Actions)
```
GCP_SA_KEY=your-service-account-key-json
DB_NAME=wordpress
DB_USER=root
DB_PASSWORD=YourSecurePassword123!
DB_HOST=astrowp-wordpress-db.astrowp-deployment:us-central1:astrowp-wordpress-db
WP_HOME=https://your-frontend-domain.netlify.app
WP_SITEURL=https://astrowp-backend-[hash].run.app
WORDPRESS_API_URL=https://astrowp-backend-[hash].run.app/graphql
NETLIFY_AUTH_TOKEN=your-netlify-auth-token
NETLIFY_SITE_ID=your-netlify-site-id
```

### Local Development
Create a `.env` file:
```
WORDPRESS_API_URL=http://localhost:8080/graphql
```

## Deployment Steps

### 1. Update Configuration Files
- Update `wp-config.php` with your actual URLs
- Update `.github/workflows/deploy.yml` with your project ID
- Update `netlify.toml` if needed

### 2. Set Up GitHub Secrets
Add all required secrets to your GitHub repository settings.

### 3. Deploy
Push to the `main` branch to trigger automatic deployment.

## Manual Deployment

### Cloud Run (Backend)
```bash
# Build and push image
docker build -t gcr.io/YOUR_PROJECT_ID/astrowp-backend .
docker push gcr.io/YOUR_PROJECT_ID/astrowp-backend

# Deploy to Cloud Run
gcloud run deploy astrowp-backend \
  --image gcr.io/YOUR_PROJECT_ID/astrowp-backend \
  --platform managed \
  --region us-central1 \
  --allow-unauthenticated
```

### Netlify (Frontend)
```bash
# Build locally
npm run build

# Deploy using Netlify CLI
netlify deploy --prod --dir=dist
```

## Post-Deployment

### WordPress Setup
1. Access your Cloud Run service URL
2. Complete WordPress installation
3. Install and activate required plugins:
   - WPGraphQL
   - WPGraphQL for ACF
   - AstroWP Hero Manager
4. Configure your site settings

### Frontend Configuration
1. Update `WORDPRESS_API_URL` in your environment variables
2. Rebuild and redeploy the frontend

## Monitoring and Maintenance

### Cloud Run
- Monitor logs: `gcloud logs read --service=astrowp-backend`
- Scale manually: `gcloud run services update astrowp-backend --max-instances=10`

### Netlify
- Monitor builds in Netlify dashboard
- Set up custom domain if needed

## Troubleshooting

### Common Issues
1. **CORS errors**: Ensure Cloud Run allows your Netlify domain
2. **Database connection**: Verify Cloud SQL connection string
3. **Build failures**: Check Node.js version compatibility

### Logs
- Cloud Run logs: Google Cloud Console
- Netlify logs: Netlify dashboard
- GitHub Actions logs: Actions tab in repository
