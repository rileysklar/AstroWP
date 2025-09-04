# AstroWP - Astro WordPress Starter

A modern, headless WordPress + Astro website with Docker development environment, Shadcn/ui components, and custom post types.

## 🚀 Tech Stack

- **Frontend**: Astro (Static Site Generation)
- **CMS**: WordPress (Headless via WPGraphQL)
- **Styling**: Tailwind CSS + Shadcn/ui
- **Language**: TypeScript
- **Database**: MariaDB
- **Development**: Docker Compose
- **API**: GraphQL (WPGraphQL)

## 📋 Prerequisites

- [Docker](https://www.docker.com/) and Docker Compose
- [Node.js](https://nodejs.org/) (v18+)
- [npm](https://www.npmjs.com/) or [yarn](https://yarnpkg.com/)

## 🚀 Quick Setup

```bash
# Clone and install
git clone https://github.com/rileysklar/AstroWP.git
cd astro-wp
npm install

# Copy environment file
cp .env.example .env

# Start WordPress and database
docker-compose up -d

# Start Astro dev server
npm run dev
```

**Note**: The `wp-content/uploads/` directory is excluded from git tracking (see `.gitignore`). WordPress will automatically create this directory and any necessary subdirectories when you upload media files through the WordPress admin.

## 🐳 WordPress Setup

### 1. Access WordPress Admin
- **URL**: http://localhost:8082/wp-admin
- **Complete WordPress installation** (site title, admin user, etc.)

### 2. Install Required Plugins
Go to **Plugins → Add New** and install:

1. **WPGraphQL** (Core GraphQL API)
2. **WPGraphQL for ACF** (Custom fields integration)
3. **Advanced Custom Fields** (Custom fields)
4. **Custom Post Type UI** (Custom post types)

### ⚠️ Important WordPress Settings

**Set permalink structure to Post name:**
- Go to **Settings → Permalinks**
- Select **"Post name"** option
- Click **"Save Changes"**

**Enable Show in GraphQL in ACF fields:**
- When creating ACF fields, go to **Advanced Settings**
- Check **"Show in GraphQL"** for each field you want to expose

### 3. Create Events Custom Post Type
Go to **Custom Post Type UI → Add/Edit Post Types**:

- **Post Type Slug**: `event`
- **Plural Label**: `Events`
- **Singular Label**: `Event`
- **Public**: ✅ Checked
- **Show in GraphQL**: ✅ Checked
- **GraphQL Single Name**: `event`
- **GraphQL Plural Name**: `events`
- **Supports**: Title, Editor, Featured Image, Excerpt
- **Has Archive**: ✅ Checked
- **Archive Slug**: `events`

### 4. Test GraphQL API
- **GraphQL IDE**: http://localhost:8082/wp-admin/admin.php?page=graphiql-ide
- **Test Query**:
```graphql
{
  posts {
    nodes {
      title
      slug
    }
  }
  events {
    nodes {
      title
      slug
    }
  }
}
```

### 5. Media Files
- **Uploads Directory**: WordPress automatically creates `wp-content/uploads/` when you upload your first media file
- **Git Tracking**: Uploads are excluded from git tracking to keep the repository clean
- **Local Development**: Each developer can have their own local media files
- **Production**: Media files should be uploaded to your production WordPress site

### 6. Hero Section Management (Optional)
To make the Hero section editable from WordPress:

**Option A: WordPress Customizer (Recommended - No Plugins Required)**
1. **Add Customizer Support** to your WordPress theme:
   ```php
   // Add to your theme's functions.php
   function astrowp_customize_register($wp_customize) {
       // Hero Section
       $wp_customize->add_section('hero_section', array(
           'title' => 'Hero Section',
           'priority' => 30,
       ));
       
       // Hero Title
       $wp_customize->add_setting('hero_title', array('default' => 'Astro WordPress'));
       $wp_customize->add_control('hero_title', array(
           'label' => 'Hero Title',
           'section' => 'hero_section',
           'type' => 'text',
       ));
       
       // Hero Subtitle
       $wp_customize->add_setting('hero_subtitle', array('default' => 'Starter'));
       $wp_customize->add_control('hero_subtitle', array(
           'label' => 'Hero Subtitle',
           'section' => 'hero_section',
           'type' => 'text',
       ));
       
       // Hero Description
       $wp_customize->add_setting('hero_description', array('default' => 'Boilerplate for Astro and WordPress using WPGraphQL, shadcn/ui, and Tailwind CSS.'));
       $wp_customize->add_control('hero_description', array(
           'label' => 'Hero Description',
           'section' => 'hero_section',
           'type' => 'textarea',
       ));
       
       // Primary Button Text
       $wp_customize->add_setting('hero_primary_button_text', array('default' => 'Explore Events'));
       $wp_customize->add_control('hero_primary_button_text', array(
           'label' => 'Primary Button Text',
           'section' => 'hero_section',
           'type' => 'text',
       ));
       
       // Primary Button Link
       $wp_customize->add_setting('hero_primary_button_link', array('default' => '/events'));
       $wp_customize->add_control('hero_primary_button_link', array(
           'label' => 'Primary Button Link',
           'section' => 'hero_section',
           'type' => 'text',
       ));
       
       // Secondary Button Text
       $wp_customize->add_setting('hero_secondary_button_text', array('default' => 'Read Posts'));
       $wp_customize->add_control('hero_secondary_button_text', array(
           'label' => 'Secondary Button Text',
           'section' => 'hero_section',
           'type' => 'text',
       ));
       
       // Secondary Button Link
       $wp_customize->add_setting('hero_secondary_button_link', array('default' => '/posts'));
       $wp_customize->add_control('hero_secondary_button_link', array(
           'label' => 'Secondary Button Link',
           'section' => 'hero_section',
           'type' => 'text',
       ));
       
       // Show Social Proof
       $wp_customize->add_setting('hero_show_social_proof', array('default' => '1'));
       $wp_customize->add_control('hero_show_social_proof', array(
           'label' => 'Show Social Proof',
           'section' => 'hero_section',
           'type' => 'checkbox',
       ));
       
       // Social Proof Text
       $wp_customize->add_setting('hero_social_proof_text', array('default' => 'Trusted by developers worldwide'));
       $wp_customize->add_control('hero_social_proof_text', array(
           'label' => 'Social Proof Text',
           'section' => 'hero_section',
           'type' => 'text',
       ));
   }
   add_action('customize_register', 'astrowp_customize_register');
   ```

2. **Edit Hero Content**: Go to **Appearance → Customize → Hero Section** to edit content

**Option B: Simple Options Page**
Create a custom admin page using WordPress Options API (no plugins required).

**Option C: Custom Post Type**
Create a "Hero" custom post type for more complex hero management.

## 🏗️ Project Structure

```
astro-wp/
├── src/
│   ├── components/
│   │   ├── sections/          # Page sections
│   │   ├── templates/         # Content templates
│   │   └── ui/               # Shadcn/ui components
│   ├── layouts/
│   ├── lib/                  # API functions
│   ├── pages/                # Astro pages
│   └── styles/
├── wp-content/               # WordPress content
├── docker-compose.yml        # Docker services
└── package.json
```

## 🌐 URL Structure

- **Posts**: `/posts` (archive) | `/post/[slug]` (individual)
- **Events**: `/events` (archive) | `/event/[slug]` (individual)
- **WordPress Admin**: http://localhost:8082/wp-admin
- **GraphQL API**: http://localhost:8082/graphql

## 🎨 UI Components

Uses [Shadcn/ui](https://ui.shadcn.com/) components:

```bash
# Add new components
npx shadcn@latest add input
npx shadcn@latest add dialog
```

## 📝 Content Management

### WordPress Admin
- **URL**: http://localhost:8082/wp-admin
- **Create posts, events, and pages**
- **Manage custom fields with ACF**
- **Configure custom post types**

### GraphQL API
- **Endpoint**: http://localhost:8082/graphql
- **IDE**: http://localhost:8082/wp-admin/admin.php?page=graphiql-ide
- **Query posts, events, and custom fields**

## 🔧 Development

```bash
npm run dev          # Start development server
npm run build        # Build for production
npm run preview      # Preview production build
```

### Docker Commands
```bash
docker-compose up -d    # Start services
docker-compose down     # Stop services
docker-compose logs     # View logs
```

## 🚀 Deployment

This project requires deploying two separate components:
1. **WordPress Backend** - Your headless CMS
2. **Astro Frontend** - Your static site

### WordPress Backend Deployment

#### Option 1: Managed WordPress Hosting (Recommended)

**Recommended Providers:**
- **WordPress.com** (Business plan or higher)
- **Kinsta**
- **WP Engine**
- **SiteGround**
- **Bluehost**

**Steps:**
1. **Choose a hosting provider** with WordPress support
2. **Install WordPress** on your hosting
3. **Install Required Plugins**:
   - WPGraphQL
   - WPGraphQL for ACF
   - Advanced Custom Fields
   - Custom Post Type UI
4. **Configure Custom Post Types** (same as local setup)
5. **Update Environment Variables** in your Astro project

#### Option 2: Self-Hosted WordPress

**Using DigitalOcean, AWS, or similar:**
1. **Set up a VPS** with LAMP/LEMP stack
2. **Install WordPress** on your server
3. **Install and configure plugins**
4. **Set up SSL certificate** (Let's Encrypt)
5. **Configure domain and DNS**

### Astro Frontend Deployment

#### Deploy to Netlify

**Step 1: Prepare for Production**
```bash
# Update your .env file with production WordPress URL
WORDPRESS_API_URL=https://your-wordpress-site.com/graphql

# Build the project
npm run build
```

**Step 2: Deploy to Netlify**
```bash
# Install Netlify CLI
npm install -g netlify-cli

# Deploy
netlify deploy --prod --dir=dist
```

**Step 3: Configure Netlify**
1. **Connect your repository** to Netlify
2. **Set build settings**:
   - Build command: `npm run build`
   - Publish directory: `dist`
3. **Set environment variables**:
   - `WORDPRESS_API_URL`: Your WordPress GraphQL endpoint
4. **Configure custom domain** (optional)

**Netlify Configuration File** (`netlify.toml`):
```toml
[build]
  command = "npm run build"
  publish = "dist"

[build.environment]
  WORDPRESS_API_URL = "https://your-wordpress-site.com/graphql"

[[redirects]]
  from = "/*"
  to = "/index.html"
  status = 200
```

#### Deploy to Vercel

**Step 1: Prepare for Production**
```bash
# Update your .env file
WORDPRESS_API_URL=https://your-wordpress-site.com/graphql

# Build the project
npm run build
```

**Step 2: Deploy to Vercel**
```bash
# Install Vercel CLI
npm install -g vercel

# Deploy
vercel --prod
```

**Step 3: Configure Vercel**
1. **Connect your repository** to Vercel
2. **Set environment variables** in Vercel dashboard:
   - `WORDPRESS_API_URL`: Your WordPress GraphQL endpoint
3. **Configure custom domain** (optional)

**Vercel Configuration File** (`vercel.json`):
```json
{
  "buildCommand": "npm run build",
  "outputDirectory": "dist",
  "env": {
    "WORDPRESS_API_URL": "https://your-wordpress-site.com/graphql"
  },
  "rewrites": [
    {
      "source": "/(.*)",
      "destination": "/index.html"
    }
  ]
}
```

### Environment Configuration

#### Production Environment Variables

Create a `.env.production` file:
```env
WORDPRESS_API_URL=https://your-wordpress-site.com/graphql
```

#### Update Astro Configuration

Update `astro.config.mjs` for production:
```javascript
import { defineConfig } from 'astro/config';
import node from "@astrojs/node";
import react from "@astrojs/react";
import tailwind from "@astrojs/tailwind";

export default defineConfig({
  integrations: [react(), tailwind()],
  output: 'static', // or 'server' for SSR
  adapter: node({
    mode: 'standalone'
  }),
  site: 'https://your-astro-site.com',
  base: '/',
});
```

### Domain and DNS Setup

#### WordPress Backend
1. **Point your domain** to your WordPress hosting
2. **Set up SSL certificate** (usually automatic with managed hosting)
3. **Test GraphQL endpoint**: `https://your-wordpress-site.com/graphql`

#### Astro Frontend
1. **Configure custom domain** in Netlify/Vercel
2. **Update DNS records** to point to your hosting provider
3. **Set up SSL certificate** (automatic with Netlify/Vercel)

### Deployment Checklist

#### Before Deployment
- [ ] WordPress site is live and accessible
- [ ] All required plugins are installed and activated
- [ ] Custom post types are configured
- [ ] GraphQL endpoint is working
- [ ] Environment variables are set correctly
- [ ] Astro site builds successfully locally

#### After Deployment
- [ ] Test all pages load correctly
- [ ] Verify GraphQL queries work
- [ ] Check custom post types display
- [ ] Test dynamic routing
- [ ] Verify images and assets load
- [ ] Check mobile responsiveness

### Cost Considerations

#### WordPress Hosting
- **Managed WordPress**: $10-50/month
- **VPS Hosting**: $5-20/month + setup time
- **WordPress.com**: $25/month (Business plan)

#### Frontend Hosting
- **Netlify**: Free tier available, $19/month for teams
- **Vercel**: Free tier available, $20/month for pro
- **Both offer**: Custom domains, SSL, CDN, analytics

### Recommended Setup

**For Small Projects:**
- WordPress: WordPress.com Business ($25/month)
- Frontend: Netlify Free tier
- Total: ~$25/month

**For Larger Projects:**
- WordPress: Kinsta ($30/month)
- Frontend: Vercel Pro ($20/month)
- Total: ~$50/month

## 📚 Resources

- [Astro Documentation](https://docs.astro.build/)
- [WPGraphQL Documentation](https://www.wpgraphql.com/docs/)
- [Shadcn/ui Documentation](https://ui.shadcn.com/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)

## 📄 License

MIT License


