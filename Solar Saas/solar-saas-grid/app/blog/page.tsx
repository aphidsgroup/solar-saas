import Link from 'next/link'
import { Button } from '@/components/ui/button'
import { 
  Calendar, 
  Clock, 
  User, 
  ArrowRight, 
  Sun, 
  TrendingUp, 
  Lightbulb,
  BarChart3,
  Zap,
  Building
} from 'lucide-react'
import { Metadata } from 'next'

export const metadata: Metadata = {
  title: 'Solar Industry Insights & Resources | SolarSaaS Grid Blog',
  description: 'Stay updated with the latest solar industry trends, SaaS insights, and renewable energy innovations from SolarSaaS Grid experts.',
  keywords: 'solar industry blog, renewable energy insights, solar SaaS trends, clean energy resources',
}

export default function BlogPage() {
  const featuredPost = {
    title: 'The Future of Solar SaaS: 5 Trends Shaping 2024',
    excerpt: 'Discover how AI, IoT integration, and community solar are revolutionizing the solar software landscape.',
    author: 'Sarah Chen',
    date: '2024-01-15',
    readTime: '8 min read',
    category: 'Industry Trends',
    image: '/blog/featured-post.jpg',
    slug: 'future-of-solar-saas-2024'
  }

  const blogPosts = [
    {
      title: 'How Community Solar is Democratizing Clean Energy Access',
      excerpt: 'Exploring the rise of community solar programs and their impact on energy equity.',
      author: 'Michael Rodriguez',
      date: '2024-01-12',
      readTime: '6 min read',
      category: 'Community Solar',
      icon: Sun,
      slug: 'community-solar-democratizing-energy'
    },
    {
      title: 'Maximizing ROI with Predictive Maintenance in Solar Parks',
      excerpt: 'Learn how AI-powered predictive maintenance is reducing O&M costs by up to 40%.',
      author: 'Dr. Priya Patel',
      date: '2024-01-10',
      readTime: '7 min read',
      category: 'Operations',
      icon: BarChart3,
      slug: 'predictive-maintenance-solar-parks'
    },
    {
      title: 'The Economics of Solar Panel Recycling: A Circular Economy Approach',
      excerpt: 'Understanding the financial and environmental benefits of responsible solar panel recycling.',
      author: 'James Wilson',
      date: '2024-01-08',
      readTime: '5 min read',
      category: 'Sustainability',
      icon: TrendingUp,
      slug: 'economics-solar-panel-recycling'
    },
    {
      title: 'Smart Home Integration: Making Solar Systems Truly Intelligent',
      excerpt: 'How IoT and smart home technology are transforming residential solar installations.',
      author: 'Lisa Zhang',
      date: '2024-01-05',
      readTime: '6 min read',
      category: 'Smart Homes',
      icon: Lightbulb,
      slug: 'smart-home-solar-integration'
    },
    {
      title: 'Digital Transformation in Solar Sales: From Leads to Installations',
      excerpt: 'Streamlining the solar sales process with CRM automation and digital tools.',
      author: 'David Kumar',
      date: '2024-01-03',
      readTime: '8 min read',
      category: 'Sales & CRM',
      icon: Zap,
      slug: 'digital-transformation-solar-sales'
    },
    {
      title: 'Utility-Scale Solar: Lessons from 1000+ MW of Installations',
      excerpt: 'Key insights from managing large-scale solar projects across different markets.',
      author: 'Maria Gonzalez',
      date: '2024-01-01',
      readTime: '9 min read',
      category: 'Utility Scale',
      icon: Building,
      slug: 'utility-scale-solar-lessons'
    }
  ]

  const categories = [
    'All Posts',
    'Industry Trends',
    'Community Solar',
    'Operations',
    'Sustainability',
    'Smart Homes',
    'Sales & CRM',
    'Utility Scale'
  ]

  return (
    <div className="min-h-screen">
      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-green-50 to-white py-20 lg:py-32 overflow-hidden">
        <div className="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
          <div className="text-center animate-fade-in">
            <h1 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
              Solar Industry <span className="text-green-600">Insights</span>
            </h1>
            <p className="text-xl md:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto">
              Stay ahead of the curve with expert insights, industry trends, and practical guides 
              for solar professionals and businesses.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
              <Button size="lg" variant="solar" asChild>
                <Link href="#featured">
                  Read Latest Posts
                  <ArrowRight className="ml-2 w-5 h-5" />
                </Link>
              </Button>
              <Button size="lg" variant="outline" asChild>
                <Link href="/contact">Subscribe to Newsletter</Link>
              </Button>
            </div>
          </div>
        </div>
      </section>

      {/* Featured Post */}
      <section id="featured" className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              Featured Article
            </h2>
          </div>

          <div className="bg-white rounded-2xl border border-gray-200 overflow-hidden hover-lift animate-slide-up">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-0">
              <div className="bg-gradient-to-br from-green-100 to-green-50 p-12 flex items-center justify-center">
                <div className="text-center">
                  <div className="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <TrendingUp className="w-12 h-12 text-white" />
                  </div>
                  <div className="text-green-600 font-medium mb-2">{featuredPost.category}</div>
                  <div className="text-4xl font-bold text-gray-900 mb-4">Featured</div>
                </div>
              </div>
              
              <div className="p-8 lg:p-12">
                <div className="flex items-center gap-4 text-sm text-gray-500 mb-4">
                  <div className="flex items-center">
                    <User className="w-4 h-4 mr-1" />
                    {featuredPost.author}
                  </div>
                  <div className="flex items-center">
                    <Calendar className="w-4 h-4 mr-1" />
                    {new Date(featuredPost.date).toLocaleDateString()}
                  </div>
                  <div className="flex items-center">
                    <Clock className="w-4 h-4 mr-1" />
                    {featuredPost.readTime}
                  </div>
                </div>
                
                <h3 className="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                  {featuredPost.title}
                </h3>
                
                <p className="text-gray-600 text-lg leading-relaxed mb-6">
                  {featuredPost.excerpt}
                </p>
                
                <Button variant="solar" asChild>
                  <Link href={`/blog/${featuredPost.slug}`}>
                    Read Full Article
                    <ArrowRight className="ml-2 w-4 h-4" />
                  </Link>
                </Button>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Categories Filter */}
      <section className="py-12 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex flex-wrap justify-center gap-3">
            {categories.map((category, index) => (
              <button
                key={category}
                className={`px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ${
                  index === 0 
                    ? 'bg-green-600 text-white' 
                    : 'bg-white text-gray-600 hover:bg-green-50 hover:text-green-600'
                }`}
              >
                {category}
              </button>
            ))}
          </div>
        </div>
      </section>

      {/* Blog Posts Grid */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {blogPosts.map((post, index) => {
              const IconComponent = post.icon
              return (
                <article
                  key={post.slug}
                  className="bg-white rounded-xl border border-gray-200 overflow-hidden hover-lift animate-slide-up"
                  style={{ animationDelay: `${index * 100}ms` }}
                >
                  <div className="p-6">
                    <div className="flex items-center justify-between mb-4">
                      <div className="flex items-center justify-center w-10 h-10 rounded-lg bg-green-50">
                        <IconComponent className="w-5 h-5 text-green-600" />
                      </div>
                      <span className="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">
                        {post.category}
                      </span>
                    </div>
                    
                    <h3 className="text-lg font-semibold text-gray-900 mb-3 line-clamp-2">
                      {post.title}
                    </h3>
                    
                    <p className="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                      {post.excerpt}
                    </p>
                    
                    <div className="flex items-center justify-between text-xs text-gray-500 mb-4">
                      <div className="flex items-center">
                        <User className="w-3 h-3 mr-1" />
                        {post.author}
                      </div>
                      <div className="flex items-center">
                        <Clock className="w-3 h-3 mr-1" />
                        {post.readTime}
                      </div>
                    </div>
                    
                    <div className="flex items-center justify-between">
                      <span className="text-xs text-gray-500">
                        {new Date(post.date).toLocaleDateString()}
                      </span>
                      <Link 
                        href={`/blog/${post.slug}`}
                        className="text-green-600 hover:text-green-700 text-sm font-medium flex items-center group"
                      >
                        Read More
                        <ArrowRight className="ml-1 w-3 h-3 group-hover:translate-x-1 transition-transform" />
                      </Link>
                    </div>
                  </div>
                </article>
              )
            })}
          </div>
        </div>
      </section>

      {/* Newsletter CTA */}
      <section className="py-20 solar-gradient">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            Stay Updated with Solar Industry Insights
          </h2>
          <p className="text-xl text-green-100 mb-8">
            Get the latest solar SaaS trends, industry analysis, and expert insights delivered to your inbox
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center max-w-md mx-auto">
            <input
              type="email"
              placeholder="Enter your email"
              className="flex-1 px-4 py-3 rounded-lg border border-green-300 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent"
            />
            <Button size="lg" variant="secondary">
              Subscribe
            </Button>
          </div>
        </div>
      </section>
    </div>
  )
} 