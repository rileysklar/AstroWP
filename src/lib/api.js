/**
 * WordPress GraphQL API functions for the AstroWP project
 * @module lib/api
 */

/**
 * Fetch navigation data and general site settings
 * @returns {Promise<Object>} Navigation and site settings data
 */
export async function navQuery() {
    try {
        const response = await fetch(import.meta.env.WORDPRESS_API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                query: `{
                    menus {
                        nodes {
                            name
                            menuItems {
                                nodes {
                                    uri
                                    url
                                    order
                                    label
                                }
                            }
                        }
                    }
                    pages(first: 100) {
                        nodes {
                            id
                            title
                            uri
                            slug
                        }
                    }
                    generalSettings {
                        title
                        url
                        description
                    }
                }`
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const { data } = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching navigation data:', error);
        return {
            menus: { nodes: [] },
            pages: { nodes: [] },
            generalSettings: { title: 'Site', description: '' }
        };
    }
}

/**
 * Fetch Hero section content from WordPress customizer options
 * @returns {Promise<Object>} Hero content data
 */
export async function heroQuery() {
    try {
        const response = await fetch(import.meta.env.WORDPRESS_API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                query: `{
                    generalSettings {
                        title
                        description
                    }
                    # Hero content from WordPress options
                    heroTitle: option(name: "hero_title")
                    heroSubtitle: option(name: "hero_subtitle")
                    heroDescription: option(name: "hero_description")
                    heroPrimaryButtonText: option(name: "hero_primary_button_text")
                    heroPrimaryButtonLink: option(name: "hero_primary_button_link")
                    heroSecondaryButtonText: option(name: "hero_secondary_button_text")
                    heroSecondaryButtonLink: option(name: "hero_secondary_button_link")
                    heroShowSocialProof: option(name: "hero_show_social_proof")
                    heroSocialProofText: option(name: "hero_social_proof_text")
                }`
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const { data } = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching hero data:', error);
        return {
            generalSettings: { title: 'AstroWP', description: '' },
            heroTitle: null,
            heroSubtitle: null,
            heroDescription: null,
            heroPrimaryButtonText: null,
            heroPrimaryButtonLink: null,
            heroSecondaryButtonText: null,
            heroSecondaryButtonLink: null,
            heroShowSocialProof: null,
            heroSocialProofText: null
        };
    }
}
export async function homePagePostsQuery() {
    try {
        const response = await fetch(import.meta.env.WORDPRESS_API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                query: `{
                    posts(first: 6) {
                        nodes {
                            date
                            uri
                            title
                            commentCount
                            excerpt
                            slug
                            categories {
                                nodes {
                                    name
                                    uri
                                }
                            }
                            featuredImage {
                                node {
                                    srcSet
                                    sourceUrl
                                    altText
                                    mediaDetails {
                                        height
                                        width
                                    }
                                }
                            }
                        }
                    }
                }`
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const { data } = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching posts:', error);
        return { posts: { nodes: [] } };
    }
}

/**
 * Fetch all events
 * @returns {Promise<Object>} Events data
 */
export async function eventsQuery() {
    try {
        const response = await fetch(import.meta.env.WORDPRESS_API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                query: `{
                    events(first: 100) {
                        nodes {
                            date
                            uri
                            title
                            content
                            slug
                            featuredImage {
                                node {
                                    srcSet
                                    sourceUrl
                                    altText
                                    mediaDetails {
                                        height
                                        width
                                    }
                                }
                            }
                        }
                    }
                }`
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();

        if (result.errors) {
            console.error('GraphQL errors:', result.errors);
            return { events: { nodes: [] } };
        }

        return result.data;
    } catch (error) {
        console.error('Error fetching events:', error);
        return { events: { nodes: [] } };
    }
}

/**
 * Fetch a specific node by its URI
 * @param {string} uri - The URI of the node to fetch
 * @returns {Promise<Object>} Node data
 */
export async function getNodeByURI(uri) {
    try {
        const response = await fetch(import.meta.env.WORDPRESS_API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                query: `query GetNodeByURI($uri: String!) {
                    nodeByUri(uri: $uri) {
                        __typename
                        isContentNode
                        isTermNode
                        ... on Post {
                            id
                            title
                            date
                            uri
                            excerpt
                            content
                            slug
                            categories {
                                nodes {
                                    name
                                    uri
                                }
                            }
                            featuredImage {
                                node {
                                    srcSet
                                    sourceUrl
                                    altText
                                    mediaDetails {
                                        height
                                        width
                                    }
                                }
                            }
                        }
                        ... on Event {
                            id
                            title
                            date
                            uri
                            content
                            slug
                            featuredImage {
                                node {
                                    srcSet
                                    sourceUrl
                                    altText
                                    mediaDetails {
                                        height
                                        width
                                    }
                                }
                            }
                        }
                        ... on Page {
                            id
                            title
                            uri
                            date
                            content
                            featuredImage {
                                node {
                                    srcSet
                                    sourceUrl
                                    altText
                                    mediaDetails {
                                        height
                                        width
                                    }
                                }
                            }
                        }
                        ... on Category {
                            id
                            name
                            posts {
                                nodes {
                                    date
                                    title
                                    excerpt
                                    uri
                                    slug
                                    categories {
                                        nodes {
                                            name
                                            uri
                                        }
                                    }
                                    featuredImage {
                                        node {
                                            srcSet
                                            sourceUrl
                                            altText
                                            mediaDetails {
                                                height
                                                width
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }`,
                variables: {
                    uri: uri
                }
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        
        const { data } = result;
        return data;
    } catch (error) {
        console.error('Error fetching node by URI:', error);
        return { nodeByUri: null };
    }
}

/**
 * Generate all URIs for static path generation
 * @returns {Promise<Array>} Array of URI parameters
 */
export async function getAllUris() {
    try {
        const response = await fetch(import.meta.env.WORDPRESS_API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                query: `query GetAllUris {
                    terms {
                        nodes {
                            uri
                        }
                    }
                    posts(first: 100) {
                        nodes {
                            uri
                        }
                    }
                    events(first: 100) {
                        nodes {
                            uri
                        }
                    }
                    pages(first: 100) {
                        nodes {
                            uri
                        }
                    }
                }`
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const { data } = await response.json();
        const uris = [];

        // Handle posts
        if (data.posts?.nodes) {
            data.posts.nodes.forEach(post => {
                if (post.uri) {
                    const trimmedURI = post.uri.replace(/^\/|\/$/g, '');
                    uris.push({
                        params: {
                            uri: trimmedURI
                        }
                    });
                }
            });
        }

        // Handle events
        if (data.events?.nodes) {
            data.events.nodes.forEach(event => {
                if (event.uri) {
                    const trimmedURI = event.uri.replace(/^\/|\/$/g, '');
                    uris.push({
                        params: {
                            uri: trimmedURI
                        }
                    });
                }
            });
        }

        // Handle pages, categories, tags
        const otherData = {
            terms: data.terms,
            pages: data.pages
        };

        Object.values(otherData)
            .filter(item => item?.nodes)
            .forEach(item => {
                item.nodes.forEach(node => {
                    if (node.uri) {
                        const trimmedURI = node.uri.replace(/^\/|\/$/g, '');
                        uris.push({
                            params: {
                                uri: trimmedURI
                            }
                        });
                    }
                });
            });

        return uris;
    } catch (error) {
        console.error('Error fetching all URIs:', error);
        return [];
    }
}

