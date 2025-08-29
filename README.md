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

### WordPress Backend
Deploy to any WordPress hosting (WordPress.com, Kinsta, WP Engine, etc.)

### Astro Frontend
Deploy to Netlify or Vercel:

```bash
# Build for production
npm run build

# Deploy to Netlify
netlify deploy --prod --dir=dist

# Deploy to Vercel
vercel --prod
```

## 📚 Resources

- [Astro Documentation](https://docs.astro.build/)
- [WPGraphQL Documentation](https://www.wpgraphql.com/docs/)
- [Shadcn/ui Documentation](https://ui.shadcn.com/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)

## 📄 License

MIT License


