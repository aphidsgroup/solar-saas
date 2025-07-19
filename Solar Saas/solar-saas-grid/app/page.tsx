import Link from 'next/link'
import { Button } from '@/components/ui/button'
import { 
  Sun, 
  Zap, 
  BarChart3, 
  Droplets, 
  Grid3X3, 
  Recycle, 
  Share2, 
  Home,
  Star,
  ArrowRight,
  Building,
  Layers,
  Cpu
} from 'lucide-react'

export default function HomePage() {
  const products = [
    {
      name: 'SalesPro',
      href: '/products/salespro',
      icon: BarChart3,
      description: 'CRM & sales management for rooftop solar EPCs and installers',
      color: 'text-blue-600'
    },
    {
      name: 'PPAFlow',
      href: '/products/ppaflow',
      icon: Zap,
      description: 'Automate your power purchase agreement lifecycle',
      color: 'text-yellow-600'
    },
    {
      name: 'ParkOps',
      href: '/products/parkops',
      icon: Building,
      description: 'Operate utility-scale solar parks like clockwork',
      color: 'text-purple-600'
    },
    {
      name: 'IrrigaPay',
      href: '/products/irrigapay',
      icon: Droplets,
      description: 'Solar irrigation billing and farmer management system',
      color: 'text-cyan-600'
    },
    {
      name: 'GridUnity',
      href: '/products/gridunity',
      icon: Grid3X3,
      description: 'Community solar and microgrid management platform',
      color: 'text-green-600'
    },
    {
      name: 'RecycleLoop',
      href: '/products/recycleloop',
      icon: Recycle,
      description: 'End-of-life solar panel tracking and recycling',
      color: 'text-emerald-600'
    },
    {
      name: 'ShareX',
      href: '/products/sharex',
      icon: Share2,
      description: 'Digital solar ownership platform for MSMEs',
      color: 'text-orange-600'
    },
    {
      name: 'SmartOS',
      href: '/products/smartos',
      icon: Home,
      description: 'Operating system for solar smart homes and buildings',
      color: 'text-indigo-600'
    }
  ]

  const benefits = [
    {
      icon: Sun,
      title: 'Built for Solar',
      description: 'Every feature designed specifically for solar energy businesses, from residential to utility-scale.'
    },
    {
      icon: Layers,
      title: 'Modular Subscriptions',
      description: 'Pick and choose the SaaS products you need. Scale up or down as your business grows.'
    },
    {
      icon: Cpu,
      title: 'Scalable APIs',
      description: 'Integrate with your existing systems through our robust APIs and developer-friendly platform.'
    }
  ]

  const testimonials = [
    {
      name: 'Sarah Chen',
      company: 'SunTech Installations',
      role: 'CEO',
      content: 'SolarSaaS SalesPro transformed our sales process. We\'ve increased our close rate by 40% and cut proposal time in half.',
      rating: 5
    },
    {
      name: 'Michael Rodriguez',
      company: 'GreenGrid Energy',
      role: 'Operations Director',
      content: 'PPAFlow automated our entire PPA lifecycle. What used to take weeks now happens in days with complete transparency.',
      rating: 5
    },
    {
      name: 'Dr. Priya Patel',
      company: 'Rural Solar Initiative',
      role: 'Program Manager',
      content: 'IrrigaPay has revolutionized how we serve farming communities. The multilingual support and offline sync are game-changers.',
      rating: 5
    }
  ]

  return (
    <div className="min-h-screen">
      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-green-50 to-white py-20 lg:py-32 overflow-hidden">
        <div className="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
          <div className="text-center animate-fade-in">
            <h1 className="text-4xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-6">
              Powering the Solar Revolution with{' '}
              <span className="text-green-600">Purpose-Built SaaS Tools</span>
            </h1>
            <p className="text-xl md:text-2xl text-gray-600 mb-8 max-w-4xl mx-auto">
              From CAPEX to Community Solar — one platform for every solar business model.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
              <Button size="xl" variant="solar" asChild>
                <Link href="#products">
                  Explore Products
                  <ArrowRight className="ml-2 w-5 h-5" />
                </Link>
              </Button>
              <Button size="xl" variant="outline" asChild>
                <Link href="/contact">Request Demo</Link>
              </Button>
            </div>
          </div>
        </div>
      </section>

      {/* Product Overview Section */}
      <section id="products" className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16 animate-slide-up">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              Complete SaaS Suite for Solar Businesses
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
              Choose from our specialized SaaS products designed for every segment of the solar industry
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {products.map((product, index) => {
              const IconComponent = product.icon
              return (
                <Link
                  key={product.name}
                  href={product.href}
                  className="group bg-white rounded-xl border border-gray-200 p-6 hover-lift hover:border-green-200 transition-all duration-300"
                  style={{ animationDelay: `${index * 100}ms` }}
                >
                  <div className="flex items-center justify-center w-12 h-12 rounded-lg bg-gray-50 group-hover:bg-green-50 transition-colors mb-4">
                    <IconComponent className={`w-6 h-6 ${product.color} group-hover:text-green-600 transition-colors`} />
                  </div>
                  <h3 className="text-lg font-semibold text-gray-900 mb-2">
                    SolarSaaS {product.name}
                  </h3>
                  <p className="text-gray-600 text-sm leading-relaxed">
                    {product.description}
                  </p>
                  <div className="mt-4 flex items-center text-green-600 text-sm font-medium group-hover:text-green-700">
                    Learn more
                    <ArrowRight className="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform" />
                  </div>
                </Link>
              )
            })}
          </div>
        </div>
      </section>

      {/* Why SolarSaaS Grid Section */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              Why SolarSaaS Grid?
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
              We understand solar because we live and breathe renewable energy
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {benefits.map((benefit, index) => {
              const IconComponent = benefit.icon
              return (
                <div
                  key={benefit.title}
                  className="text-center animate-slide-up"
                  style={{ animationDelay: `${index * 200}ms` }}
                >
                  <div className="flex items-center justify-center w-16 h-16 rounded-full solar-gradient mx-auto mb-6">
                    <IconComponent className="w-8 h-8 text-white" />
                  </div>
                  <h3 className="text-xl font-semibold text-gray-900 mb-4">
                    {benefit.title}
                  </h3>
                  <p className="text-gray-600 leading-relaxed">
                    {benefit.description}
                  </p>
                </div>
              )
            })}
          </div>
        </div>
      </section>

      {/* Testimonials Section */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              Trusted by Solar Leaders
            </h2>
            <p className="text-xl text-gray-600">
              See what our customers are saying about SolarSaaS Grid
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {testimonials.map((testimonial, index) => (
              <div
                key={testimonial.name}
                className="bg-white rounded-xl border border-gray-200 p-6 hover-lift animate-slide-up"
                style={{ animationDelay: `${index * 150}ms` }}
              >
                <div className="flex items-center mb-4">
                  {[...Array(testimonial.rating)].map((_, i) => (
                    <Star key={i} className="w-5 h-5 text-yellow-400 fill-current" />
                  ))}
                </div>
                <p className="text-gray-700 mb-6 italic">
                  &ldquo;{testimonial.content}&rdquo;
                </p>
                <div>
                  <div className="font-semibold text-gray-900">{testimonial.name}</div>
                  <div className="text-sm text-gray-600">
                    {testimonial.role}, {testimonial.company}
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Final CTA Section */}
      <section className="py-20 solar-gradient">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            Not sure which fits your business?
          </h2>
          <p className="text-xl text-green-100 mb-8">
            Talk to a SaaS expert and discover the perfect solution for your solar business
          </p>
          <Button size="xl" variant="secondary" asChild>
            <Link href="/contact">
              Talk to a SaaS Expert
              <ArrowRight className="ml-2 w-5 h-5" />
            </Link>
          </Button>
        </div>
      </section>
    </div>
  )
}
