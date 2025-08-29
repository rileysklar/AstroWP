# AstroWP - Astro WordPress Starter

A modern, headless WordPress + Astro website with Docker development environment, Shadcn/ui components, dynamic routing, and custom post types.

## 🚀 Features

- **Headless WordPress CMS** - Content management with WPGraphQL API
- **Astro Frontend** - Fast, modern static site generation with dynamic routing
- **Docker Development** - Complete local development environment
- **Shadcn/ui Components** - Beautiful, accessible UI components
- **Custom Post Types** - Events and other content types
- **Dynamic Routing** - Real-time URL generation based on WordPress slugs
- **Tailwind CSS** - Utility-first styling
- **TypeScript** - Type-safe development
- **GraphQL API** - Flexible data fetching

## 📋 Requirements

- [Docker](https://www.docker.com/) and Docker Compose
- [Node.js](https://nodejs.org/) (v18+)
- [npm](https://www.npmjs.com/) or [yarn](https://yarnpkg.com/)

## 🐳 WordPress Docker Setup

This project includes a complete WordPress development environment using Docker Compose.

### **Docker Services**

The `docker-compose.yml` file includes:

- **WordPress**: Latest WordPress version on port 8082
- **MariaDB**: Database server (compatible with Apple Silicon)
- **phpMyAdmin**: Database management interface on port 8081

### **Required WordPress Plugins**

The following plugins are essential for the headless WordPress setup:

#### **Core Plugins**

1. **WPGraphQL** (Required)
   - **Purpose**: Exposes WordPress data via GraphQL API
   - **GraphQL Endpoint**: `/graphql`
   - **Features**: 
     - Query posts, pages, custom post types
     - Real-time data fetching
     - Type-safe API responses
   - **Configuration**: Enable debug mode for development

2. **WPGraphQL for ACF** (Required)
   - **Purpose**: Integrates Advanced Custom Fields with GraphQL
   - **Features**:
     - Exposes ACF fields in GraphQL queries
     - Supports complex field types
     - Enables custom field queries

3. **Advanced Custom Fields (ACF)** (Required)
   - **Purpose**: Provides custom field functionality
   - **Features**:
     - Create custom fields for posts and custom post types
     - Field types: Text, Textarea, Image, Date, etc.
     - Conditional logic and field groups

4. **Custom Post Type UI (CPT UI)** (Required)
   - **Purpose**: Creates and manages custom post types
   - **Features**:
     - User-friendly interface for CPT creation
     - GraphQL integration settings
     - Archive and single page configuration

#### **Optional Plugins**

5. **Classic Editor** (Optional)
   - **Purpose**: Disables Gutenberg editor if preferred

### **Plugin Installation Order**

1. Install and activate **WPGraphQL** first
2. Install and activate **Advanced Custom Fields**
3. Install and activate **WPGraphQL for ACF**
4. Install and activate **Custom Post Type UI**
5. Create custom post types
6. Configure GraphQL settings

### **Docker Commands**

```bash
# Start all services
docker-compose up -d

# Stop all services
docker-compose down

# View logs
docker-compose logs -f

# Restart services
docker-compose restart

# Rebuild containers
docker-compose up -d --build

# Access WordPress container
docker-compose exec wordpress bash

# Access database
docker-compose exec db mysql -u wordpress -p wordpress
```

### **Environment Variables**

The Docker setup uses these environment variables:

```env
# WordPress
WORDPRESS_DB_HOST=db
WORDPRESS_DB_USER=wordpress
WORDPRESS_DB_PASSWORD=wordpress
WORDPRESS_DB_NAME=wordpress

# MariaDB
MYSQL_DATABASE=wordpress
MYSQL_USER=wordpress
MYSQL_PASSWORD=wordpress
MYSQL_ROOT_PASSWORD=root

# phpMyAdmin
PMA_HOST=db
MYSQL_ROOT_PASSWORD=root
```

### **Ports**

- **WordPress**: http://localhost:8082
- **phpMyAdmin**: http://localhost:8081
- **Astro Dev Server**: http://localhost:4333

### **Step 1: Prerequisites**

Ensure you have the following installed:
- [Docker](https://www.docker.com/) and Docker Compose
- [Node.js](https://nodejs.org/) (v18+)
- [npm](https://www.npmjs.com/) or [yarn](https://yarnpkg.com/)

### **Step 2: Clone and Install**

```bash
git clone <repository-url>
cd astro-wp
npm install
```

### **Step 3: Environment Setup**

Create a `.env` file in the root directory:

```bash
cp .env.example .env
```

Edit `.env` with your configuration:

```env
WORDPRESS_API_URL=http://localhost:8082/graphql
```

### **Step 4: Start Docker Services**

```bash
# Start WordPress, MariaDB, and phpMyAdmin
docker-compose up -d

# Verify containers are running
docker-compose ps
```

### **Step 5: WordPress Initial Setup**

1. **Access WordPress Admin**: http://localhost:8082/wp-admin
2. **Complete WordPress Installation**:
   - Choose your language
   - Enter site title (e.g., "AstroWP")
   - Create admin username and password
   - Enter your email address
   - Click "Install WordPress"

### **Step 6: Install Required WordPress Plugins**

After WordPress installation, install these essential plugins:

#### **WPGraphQL (Core Plugin)**
1. Go to **Plugins → Add New**
2. Search for "WPGraphQL"
3. Click **Install** then **Activate**
4. Go to **GraphQL → Settings**
5. Enable **Debug Mode** for development
6. Save changes

#### **WPGraphQL for ACF (Advanced Custom Fields Integration)**
1. Go to **Plugins → Add New**
2. Search for "WPGraphQL for ACF"
3. Click **Install** then **Activate**
4. This enables Advanced Custom Fields in GraphQL queries

#### **Advanced Custom Fields (ACF)**
1. Go to **Plugins → Add New**
2. Search for "Advanced Custom Fields"
3. Click **Install** then **Activate**
4. This provides custom fields functionality

#### **Custom Post Type UI (CPT UI)**
1. Go to **Plugins → Add New**
2. Search for "Custom Post Type UI"
3. Click **Install** then **Activate**
4. This provides an interface for creating custom post types

### **Step 7: Configure Custom Post Types**

#### **Create Events Custom Post Type**
1. Go to **Custom Post Type UI → Add/Edit Post Types**
2. **Post Type Slug**: `event`
3. **Plural Label**: `Events`
4. **Singular Label**: `Event`
5. **Public**: ✅ Checked
6. **Show in GraphQL**: ✅ Checked
7. **GraphQL Single Name**: `event`
8. **GraphQL Plural Name**: `events`
9. **Supports**: Title, Editor, Featured Image, Excerpt, Custom Fields
10. **Has Archive**: ✅ Checked
11. **Archive Slug**: `events`
12. Click **Add Post Type**

#### **Configure GraphQL Settings for Events**
1. Go to **GraphQL → Settings**
2. Scroll to **Post Types** section
3. Ensure **Events** is enabled for GraphQL
4. **GraphQL Single Name**: `event`
5. **GraphQL Plural Name**: `events`
6. Save changes

#### **Optional: Create Additional Custom Post Types**
You can create additional custom post types following the same pattern:

**Example: Services Post Type**
- **Post Type Slug**: `service`
- **Plural Label**: `Services`
- **Singular Label**: `Service`
- **GraphQL Single Name**: `service`
- **GraphQL Plural Name**: `services`

### **Step 8: Test GraphQL API**

1. **Access GraphQL IDE**: http://localhost:8082/wp-admin/admin.php?page=graphiql-ide
2. **Test Posts Query**:
```graphql
{
  posts {
    nodes {
      title
      slug
      date
    }
  }
}
```
3. **Test Events Query**:
```graphql
{
  events {
    nodes {
      title
      slug
      date
    }
  }
}
```

### **Step 9: Start Astro Development Server**

```bash
npm run dev
```

### **Step 10: Verify Everything Works**

- **Astro Site**: http://localhost:4333/
- **WordPress Admin**: http://localhost:8082/wp-admin
- **GraphQL API**: http://localhost:8082/graphql
- **phpMyAdmin**: http://localhost:8081

## 🚀 Quick Start (Alternative)

If you want to skip the detailed setup:

```bash
# Clone and install
git clone <repository-url>
cd astro-wp
npm install

# Copy environment file
cp .env.example .env

# Start everything
docker-compose up -d
npm run dev

# Then follow WordPress setup steps 5-8 above
```

## 🏗️ Project Structure

```
astro-wp/
├── 📁 src/
│   ├── 📁 components/
│   │   ├── 📁 sections/              # Page sections
│   │   │   ├── Hero.astro           # Hero section with Shadcn/ui
│   │   │   ├── RecentPosts.astro    # Recent posts grid
│   │   │   └── RecentEvents.astro   # Recent events grid
│   │   ├── 📁 templates/            # Content templates
│   │   │   ├── Single.astro         # Individual post/event view
│   │   │   └── Archive.astro        # Category/tag archive view
│   │   ├── 📁 ui/                   # Shadcn/ui components
│   │   │   ├── button.tsx           # Button component
│   │   │   └── card.tsx             # Card component
│   │   ├── SiteNav.astro            # Navigation
│   │   └── SiteFooter.astro         # Footer
│   ├── 📁 layouts/
│   │   └── MainLayout.astro         # Main page layout
│   ├── 📁 lib/
│   │   └── api.js                   # WordPress GraphQL API functions
│   ├── 📁 pages/
│   │   ├── index.astro              # Home page
│   │   ├── posts.astro              # Posts archive page
│   │   ├── events.astro             # Events archive page
│   │   ├── posts/[...slug].astro    # Dynamic post routes
│   │   ├── events/[...slug].astro    # Dynamic event routes
│   │   └── [...uri].astro           # Fallback dynamic routes
│   └── 📁 styles/
│       └── global.css               # Global styles + Tailwind
├── 📁 public/                       # Static assets
├── 📁 wp-content/                   # WordPress content
├── docker-compose.yml              # Docker services
├── astro.config.mjs                # Astro configuration
├── tailwind.config.js              # Tailwind CSS config
├── components.json                  # Shadcn/ui configuration
└── package.json                    # Dependencies
```

## 🌐 URL Structure & Routing

The project implements a clean, SEO-friendly URL structure with proper routing to avoid conflicts:

### **📄 Content Routes**
- **Individual Posts**: `/post/[slug]` (e.g., `/post/my-awesome-post`)
- **Individual Events**: `/event/[slug]` (e.g., `/event/tech-conference-2024`)

### **📚 Archive Routes**  
- **All Posts**: `/posts` (archive listing)
- **All Events**: `/events` (archive listing)

### **🔧 Routing Architecture**
```
src/pages/
├── post/[...slug].astro     # Individual post pages (/post/[slug])
├── event/[...slug].astro    # Individual event pages (/event/[slug])
├── posts.astro             # Posts archive (/posts)
├── events.astro            # Events archive (/events)
└── [...uri].astro          # Fallback for other content
```

### **⚡ Dynamic Routing**
- **Real-time slug updates**: When you change a slug in WordPress, the URL automatically updates
- **No static generation**: Content is fetched at request time for maximum flexibility
- **Fallback handling**: Multiple URI patterns tried before 404 redirect

### **🔗 Internal Links**
- Cards link to individual content: `/post/[slug]` and `/event/[slug]`
- Archive buttons link to listings: `/posts` and `/events`
- Navigation respects the routing structure

### **Posts**
- **Archive**: `/posts` - All blog posts
- **Individual**: `/post/[slug]` - Single post (e.g., `/post/hello-world`)

### **Events**
- **Archive**: `/events` - All events  
- **Individual**: `/event/[slug]` - Single event (e.g., `/event/summer-festival`)

### **Dynamic Routing**
- Routes automatically adapt to WordPress slug changes
- No build-time generation - content fetched at request time
- Automatic 404 handling for missing content

## 🎨 UI Components

This project uses [Shadcn/ui](https://ui.shadcn.com/) for beautiful, accessible components.

### Available Components

- **Button** - Various button styles and variants
- **Card** - Content containers with header, content, and description

### Adding New Components

```bash
npx shadcn@latest add input
npx shadcn@latest add dialog
npx shadcn@latest add dropdown-menu
```

### Using Components

```astro
---
import { Button } from "../components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "../components/ui/card";
---

<Button variant="default">Click me</Button>

<Card>
  <CardHeader>
    <CardTitle>Card Title</CardTitle>
  </CardHeader>
  <CardContent>
    <p>Card content goes here</p>
  </CardContent>
</Card>
```

## 📝 Content Management

### WordPress Setup

1. **Access WordPress Admin**: http://localhost:8082/wp-admin
2. **Complete Initial Setup**: Follow WordPress installation wizard
3. **Install Required Plugins**:
   - WPGraphQL (already installed)
   - WPGraphQL for ACF (for custom fields)

### GraphQL Setup

The project uses **WPGraphQL** to expose WordPress data via GraphQL API.

#### Required Plugins

1. **WPGraphQL** (Core Plugin)
   - Automatically installed via Docker
   - Provides GraphQL endpoint at `/graphql`
   - Enables querying posts, pages, custom post types

2. **WPGraphQL for ACF** (Advanced Custom Fields Integration)
   - Install from WordPress Admin: Plugins → Add New
   - Search for "WPGraphQL for ACF"
   - Activate the plugin
   - Makes ACF fields available in GraphQL queries

#### GraphQL Configuration

1. **Enable GraphQL Introspection** (for development):
   - Go to: GraphQL → Settings
   - Enable "Public Introspection Enabled"
   - This allows exploring the schema in GraphiQL

2. **Test GraphQL Endpoint**:
   - Visit: http://localhost:8082/graphql
   - You should see the GraphiQL interface
   - Try this query:
   ```graphql
   {
     posts {
       nodes {
         title
         slug
         uri
       }
     }
   }
   ```

## 📝 Custom Post Types

This project includes a comprehensive custom post type system that integrates seamlessly with GraphQL and Astro.

### **Events Custom Post Type**

The Events post type is pre-configured and includes:

#### **Configuration**
- **Post Type Slug**: `event`
- **Plural Label**: `Events`
- **Singular Label**: `Event`
- **GraphQL Single Name**: `event`
- **GraphQL Plural Name**: `events`
- **Archive Slug**: `events`

#### **Supported Features**
- ✅ Title and Content Editor
- ✅ Featured Images
- ✅ Excerpts
- ✅ Custom Fields (via ACF)
- ✅ Archive Pages
- ✅ GraphQL Integration
- ✅ SEO Meta Fields

#### **GraphQL Query Examples**

**Fetch All Events:**
```graphql
{
  events(first: 100) {
    nodes {
      id
      title
      slug
      uri
      date
      excerpt
      content
      featuredImage {
        node {
          sourceUrl
          altText
          mediaDetails {
            width
            height
          }
        }
      }
    }
  }
}
```

**Fetch Single Event:**
```graphql
{
  event(id: "event-slug", idType: SLUG) {
    title
    content
    date
    featuredImage {
      node {
        sourceUrl
        altText
      }
    }
  }
}
```

### **Creating Additional Custom Post Types**

#### **Step-by-Step Process**

1. **Install Required Plugins** (if not already installed):
   - Custom Post Type UI
   - WPGraphQL
   - Advanced Custom Fields (for custom fields)

2. **Create the Custom Post Type**:
   - Go to **Custom Post Type UI → Add/Edit Post Types**
   - Fill in the basic settings
   - Enable GraphQL integration
   - Configure archive settings

3. **Configure GraphQL Settings**:
   - Go to **GraphQL → Settings**
   - Enable the new post type for GraphQL
   - Set GraphQL names

4. **Add Custom Fields** (Optional):
   - Go to **Custom Fields → Add New**
   - Create field groups
   - Assign to your custom post type
   - Fields will automatically appear in GraphQL

#### **Example: Services Post Type**

**Basic Configuration:**
- **Post Type Slug**: `service`
- **Plural Label**: `Services`
- **Singular Label**: `Service`
- **GraphQL Single Name**: `service`
- **GraphQL Plural Name**: `services`
- **Archive Slug**: `services`

**Custom Fields Example:**
```php
// ACF Field Group: Service Details
- Service Price (Text)
- Service Duration (Text)
- Service Category (Taxonomy)
- Service Features (Repeater)
```

**GraphQL Query:**
```graphql
{
  services(first: 10) {
    nodes {
      title
      content
      slug
      servicePrice
      serviceDuration
      serviceCategory {
        nodes {
          name
          slug
        }
      }
      serviceFeatures {
        feature
        description
      }
    }
  }
}
```

### **Astro Integration**

Custom post types are automatically integrated into the Astro frontend:

#### **Dynamic Routes**
- **Individual Pages**: `/service/[slug].astro`
- **Archive Pages**: `/services.astro`

#### **API Functions**
Add to `src/lib/api.js`:
```javascript
export async function servicesQuery() {
  // GraphQL query for services
}

export async function getServiceBySlug(slug) {
  // GraphQL query for single service
}
```

#### **Components**
Create components in `src/components/sections/`:
- `RecentServices.astro`
- `ServiceCard.astro`
- `ServiceArchive.astro`

### **Best Practices**

1. **Naming Convention**:
   - Use lowercase, hyphenated slugs
   - Keep GraphQL names simple and clear
   - Use consistent plural/singular naming

2. **GraphQL Configuration**:
   - Always enable GraphQL for custom post types
   - Use descriptive GraphQL names
   - Test queries in GraphiQL before implementing

3. **Custom Fields**:
   - Group related fields together
   - Use appropriate field types
   - Consider conditional logic for complex forms

4. **Performance**:
   - Limit query results with `first` parameter
   - Use specific field selection
   - Implement caching where appropriate

### GraphQL Queries

Test your API at http://localhost:8082/graphql:

```graphql
# Get all posts with slugs
{
  posts {
    nodes {
      title
      slug
      uri
      date
    }
  }
}

# Get all events with slugs
{
  events {
    nodes {
      title
      slug
      uri
      date
    }
  }
}

# Get both posts and events
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

## 🔧 Development

### Available Scripts

```bash
npm run dev          # Start development server
npm run build        # Build for production
npm run preview      # Preview production build
npm run astro        # Run Astro CLI commands
```

### Docker Commands

```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs

# Restart services
docker-compose restart
```

### Dynamic Routing System

The project uses Astro's dynamic routing to handle WordPress content:

#### **Post Routes** (`/posts/[...slug].astro`)
- Fetches posts by slug dynamically
- Tries multiple URI patterns to find content
- Falls back to fetching all posts and matching by slug
- Handles 404s gracefully

#### **Event Routes** (`/events/[...slug].astro`)
- Fetches events by slug dynamically
- Tries multiple URI patterns to find content
- Falls back to fetching all events and matching by slug
- Handles 404s gracefully

#### **Fallback Routes** (`/[...uri].astro`)
- Handles categories, tags, and other content types
- Uses template system to render appropriate layouts

### Adding Custom Post Types

1. **Create in WordPress Admin**: Custom Post Types → Add New
2. **Configure GraphQL Settings**:
   - Enable "Show in GraphQL"
   - Set GraphQL Single Name (e.g., `event`)
   - Set GraphQL Plural Name (e.g., `events`)
3. **Update API Functions**: Add to `src/lib/api.js`
4. **Create Templates**: Add to `src/components/templates/`

### API Functions

The project includes several API functions in `src/lib/api.js`:

```javascript
// Fetch recent posts for home page
export async function homePagePostsQuery()

// Fetch all events
export async function eventsQuery()

// Fetch individual content by URI
export async function getNodeByURI(uri)

// Fetch navigation and site settings
export async function navQuery()

// Generate all URIs for static paths
export async function getAllUris()
```

## 🚀 Deployment

### **Overview**

This project requires deploying two separate components:
1. **WordPress Backend** - Your headless CMS
2. **Astro Frontend** - Your static site

### **WordPress Backend Deployment**

#### **Option 1: Managed WordPress Hosting (Recommended)**

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

#### **Option 2: Self-Hosted WordPress**

**Using DigitalOcean, AWS, or similar:**
1. **Set up a VPS** with LAMP/LEMP stack
2. **Install WordPress** on your server
3. **Install and configure plugins**
4. **Set up SSL certificate** (Let's Encrypt)
5. **Configure domain and DNS**

### **Astro Frontend Deployment**

#### **Deploy to Netlify**

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

#### **Deploy to Vercel**

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

### **Environment Configuration**

#### **Production Environment Variables**

Create a `.env.production` file:
```env
WORDPRESS_API_URL=https://your-wordpress-site.com/graphql
```

#### **Update Astro Configuration**

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

### **Domain and DNS Setup**

#### **WordPress Backend**
1. **Point your domain** to your WordPress hosting
2. **Set up SSL certificate** (usually automatic with managed hosting)
3. **Test GraphQL endpoint**: `https://your-wordpress-site.com/graphql`

#### **Astro Frontend**
1. **Configure custom domain** in Netlify/Vercel
2. **Update DNS records** to point to your hosting provider
3. **Set up SSL certificate** (automatic with Netlify/Vercel)

### **Deployment Checklist**

#### **Before Deployment**
- [ ] WordPress site is live and accessible
- [ ] All required plugins are installed and activated
- [ ] Custom post types are configured
- [ ] GraphQL endpoint is working
- [ ] Environment variables are set correctly
- [ ] Astro site builds successfully locally

#### **After Deployment**
- [ ] Test all pages load correctly
- [ ] Verify GraphQL queries work
- [ ] Check custom post types display
- [ ] Test dynamic routing
- [ ] Verify images and assets load
- [ ] Check mobile responsiveness

### **Troubleshooting Deployment**

#### **Common Issues**

**GraphQL Connection Errors**
- Verify WordPress URL is correct and accessible
- Check if WordPress plugins are activated
- Ensure GraphQL endpoint is working: `https://your-site.com/graphql`

**Build Failures**
- Check environment variables are set
- Verify all dependencies are installed
- Check for TypeScript/JavaScript errors

**404 Errors on Dynamic Routes**
- Configure redirects in Netlify/Vercel
- Ensure WordPress content exists
- Check GraphQL queries are working

**Performance Issues**
- Enable caching in Netlify/Vercel
- Optimize images and assets
- Consider using CDN for static assets

### **Cost Considerations**

#### **WordPress Hosting**
- **Managed WordPress**: $10-50/month
- **VPS Hosting**: $5-20/month + setup time
- **WordPress.com**: $25/month (Business plan)

#### **Frontend Hosting**
- **Netlify**: Free tier available, $19/month for teams
- **Vercel**: Free tier available, $20/month for pro
- **Both offer**: Custom domains, SSL, CDN, analytics

### **Recommended Setup**

**For Small Projects:**
- WordPress: WordPress.com Business ($25/month)
- Frontend: Netlify Free tier
- Total: ~$25/month

**For Larger Projects:**
- WordPress: Kinsta ($30/month)
- Frontend: Vercel Pro ($20/month)
- Total: ~$50/month

## 🔍 Troubleshooting

### Common Issues

**404 Errors on Dynamic Routes**
- Ensure WordPress is running and accessible
- Check GraphQL endpoint is working
- Verify post/event slugs exist in WordPress
- Check browser console for API errors

**GraphQL Connection Issues**
- Verify `WORDPRESS_API_URL` in `.env` file
- Ensure WPGraphQL plugin is activated
- Check WordPress admin for plugin status

**Styling Issues**
- Ensure Tailwind CSS is properly configured
- Check `src/styles/global.css` for Tailwind directives
- Verify Shadcn/ui components are imported correctly

**Docker Issues**
- Check if ports 8081, 8082, 4333 are available
- Restart Docker services: `docker-compose restart`
- Check logs: `docker-compose logs`

### WordPress Docker Troubleshooting

**WordPress Container Won't Start**
```bash
# Check container logs
docker-compose logs wordpress

# Check if database is accessible
docker-compose exec wordpress wp db check

# Restart all services
docker-compose down && docker-compose up -d
```

**Database Connection Issues**
```bash
# Check database container
docker-compose logs db

# Access database directly
docker-compose exec db mysql -u wordpress -p wordpress

# Reset database (WARNING: This will delete all data)
docker-compose down -v && docker-compose up -d
```

**Plugin Installation Issues**
- Ensure WordPress is fully installed before installing plugins
- Check plugin compatibility with WordPress version
- Verify plugin files are properly uploaded to `wp-content/plugins/`
- Check WordPress debug logs: `docker-compose logs wordpress`

**GraphQL Endpoint Not Working**
1. Verify WPGraphQL plugin is activated
2. Check GraphQL settings in WordPress admin
3. Test endpoint: `curl -X POST http://localhost:8082/graphql`
4. Check for PHP errors in container logs

**Custom Post Types Not Appearing in GraphQL**
1. Ensure CPT UI plugin is activated
2. Verify post type is enabled for GraphQL in CPT UI settings
3. Check GraphQL settings for the post type
4. Clear any caching plugins
5. Test in GraphiQL: http://localhost:8082/wp-admin/admin.php?page=graphiql-ide

**Port Conflicts**
```bash
# Check what's using the ports
lsof -i :8081
lsof -i :8082
lsof -i :4333

# Change ports in docker-compose.yml if needed
ports:
  - "8083:80"  # Change from 8082 to 8083
```

**Performance Issues**
- Increase Docker memory allocation
- Use volume mounts for better I/O performance
- Consider using Docker Desktop's WSL2 backend on Windows
- Monitor container resource usage: `docker stats`

## 📚 Resources

- [Astro Documentation](https://docs.astro.build/)
- [WPGraphQL Documentation](https://www.wpgraphql.com/docs/)
- [Shadcn/ui Documentation](https://ui.shadcn.com/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Docker Documentation](https://docs.docker.com/)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License.

---

Built with ❤️ using Astro, WordPress, and modern web technologies.


