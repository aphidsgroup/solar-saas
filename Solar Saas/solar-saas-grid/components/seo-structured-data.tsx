import { Metadata } from 'next'

interface StructuredDataProps {
  type: 'Organization' | 'Product' | 'SoftwareApplication' | 'Article' | 'WebPage'
  data: Record<string, unknown>
}

export function StructuredData({ type, data }: StructuredDataProps) {
  const structuredData: Record<string, unknown> = {
    '@context': 'https://schema.org',
    '@type': type,
    ...data
  }

  // Add common organization data for all types
  if (type !== 'Organization') {
    structuredData.provider = {
      '@type': 'Organization',
      name: 'SolarSaaS Grid',
      url: 'https://solarsaasgrid.com',
      logo: 'https://solarsaasgrid.com/logo.png',
      description: 'Comprehensive SaaS solutions for the solar energy industry',
      foundingDate: '2024',
      industry: 'Solar Energy Software',
      address: {
        '@type': 'PostalAddress',
        addressCountry: 'US',
        addressRegion: 'CA',
        addressLocality: 'San Francisco'
      }
    }
  }

  return (
    <script
      type="application/ld+json"
      dangerouslySetInnerHTML={{
        __html: JSON.stringify(structuredData)
      }}
    />
  )
}

// Organization structured data
export function OrganizationStructuredData() {
  const organizationData = {
    name: 'SolarSaaS Grid',
    alternateName: 'SolarSaaS',
    url: 'https://solarsaasgrid.com',
    logo: 'https://solarsaasgrid.com/logo.png',
    description: 'Leading provider of SaaS solutions for the solar energy industry, offering comprehensive software tools for sales, operations, community solar, and smart home integration.',
    foundingDate: '2024',
    industry: 'Solar Energy Software',
    numberOfEmployees: '50-100',
    address: {
      '@type': 'PostalAddress',
      streetAddress: '123 Solar Street',
      addressLocality: 'San Francisco',
      addressRegion: 'CA',
      postalCode: '94105',
      addressCountry: 'US'
    },
    contactPoint: {
      '@type': 'ContactPoint',
      telephone: '+1-555-SOLAR-01',
      contactType: 'customer service',
      email: 'contact@solarsaasgrid.com',
      availableLanguage: 'English'
    },
    sameAs: [
      'https://linkedin.com/company/solarsaasgrid',
      'https://twitter.com/solarsaasgrid',
      'https://github.com/solarsaasgrid'
    ],
    hasOfferCatalog: {
      '@type': 'OfferCatalog',
      name: 'Solar SaaS Products',
      itemListElement: [
        {
          '@type': 'Offer',
          itemOffered: {
            '@type': 'SoftwareApplication',
            name: 'SolarSaaS SalesPro',
            description: 'CRM and sales management for solar businesses'
          }
        },
        {
          '@type': 'Offer',
          itemOffered: {
            '@type': 'SoftwareApplication',
            name: 'SolarSaaS ParkOps',
            description: 'Utility-scale solar park operations management'
          }
        }
      ]
    }
  }

  return <StructuredData type="Organization" data={organizationData} />
}

// Product structured data
export function ProductStructuredData({ 
  name, 
  description, 
  price, 
  category,
  features 
}: {
  name: string
  description: string
  price?: string
  category: string
  features: string[]
}) {
  const productData = {
    name,
    description,
    category,
    applicationCategory: 'BusinessApplication',
    operatingSystem: 'Web-based',
    offers: price ? {
      '@type': 'Offer',
      price,
      priceCurrency: 'USD',
      availability: 'https://schema.org/InStock',
      validFrom: new Date().toISOString()
    } : undefined,
    featureList: features,
    screenshot: `https://solarsaasgrid.com/screenshots/${name.toLowerCase().replace(/\s+/g, '-')}.png`,
    softwareVersion: '2024.1',
    releaseNotes: 'Latest version with enhanced features and improved performance'
  }

  return <StructuredData type="SoftwareApplication" data={productData} />
}

// Article structured data for blog posts
export function ArticleStructuredData({
  headline,
  description,
  author,
  datePublished,
  dateModified,
  image,
  category
}: {
  headline: string
  description: string
  author: string
  datePublished: string
  dateModified?: string
  image?: string
  category: string
}) {
  const articleData = {
    headline,
    description,
    image: image || 'https://solarsaasgrid.com/blog/default-image.jpg',
    author: {
      '@type': 'Person',
      name: author
    },
    publisher: {
      '@type': 'Organization',
      name: 'SolarSaaS Grid',
      logo: {
        '@type': 'ImageObject',
        url: 'https://solarsaasgrid.com/logo.png'
      }
    },
    datePublished,
    dateModified: dateModified || datePublished,
    mainEntityOfPage: {
      '@type': 'WebPage',
      '@id': 'https://solarsaasgrid.com/blog'
    },
    articleSection: category,
    keywords: ['solar energy', 'SaaS', 'renewable energy', category.toLowerCase()]
  }

  return <StructuredData type="Article" data={articleData} />
}

// Enhanced metadata generator
export function generateMetadata({
  title,
  description,
  keywords,
  canonical,
  ogImage,
  noIndex = false
}: {
  title: string
  description: string
  keywords?: string
  canonical?: string
  ogImage?: string
  noIndex?: boolean
}): Metadata {
  const baseUrl = 'https://solarsaasgrid.com'
  const defaultOgImage = `${baseUrl}/og-image.jpg`

  return {
    title,
    description,
    keywords,
    robots: noIndex ? 'noindex,nofollow' : 'index,follow',
    openGraph: {
      title,
      description,
      url: canonical || baseUrl,
      siteName: 'SolarSaaS Grid',
      images: [
        {
          url: ogImage || defaultOgImage,
          width: 1200,
          height: 630,
          alt: title
        }
      ],
      locale: 'en_US',
      type: 'website'
    },
    twitter: {
      card: 'summary_large_image',
      title,
      description,
      images: [ogImage || defaultOgImage],
      creator: '@solarsaasgrid'
    },
    alternates: {
      canonical: canonical || baseUrl
    },
    other: {
      'theme-color': '#16a34a',
      'apple-mobile-web-app-capable': 'yes',
      'apple-mobile-web-app-status-bar-style': 'default'
    }
  }
} 