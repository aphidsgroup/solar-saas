import Link from 'next/link'
import { Button } from '@/components/ui/button'
import { 
  Grid3X3, 
  Users, 
  Zap, 
  Shield, 
  BarChart3, 
  Smartphone, 
  CheckCircle, 
  ArrowRight,
  Home,
  Building2,
  Leaf,
  Globe
} from 'lucide-react'
import { Metadata } from 'next'

export const metadata: Metadata = {
  title: 'GridUnity - Community Solar & Microgrid Management | SolarSaaS Grid',
  description: 'Manage community solar projects and microgrids with subscriber management, billing automation, and grid integration tools.',
  keywords: 'community solar, microgrid management, solar sharing, distributed energy, renewable energy community',
}

export default function GridUnityPage() {
  const features = [
    {
      icon: Users,
      title: 'Subscriber Management',
      description: 'Manage thousands of community solar subscribers with automated onboarding, billing, and customer service tools.'
    },
    {
      icon: BarChart3,
      title: 'Production Allocation',
      description: 'Automatically allocate solar production to subscribers based on their share size and consumption patterns.'
    },
    {
      icon: Zap,
      title: 'Microgrid Control',
      description: 'Intelligent control systems for islanding, load balancing, and seamless grid integration.'
    },
    {
      icon: Smartphone,
      title: 'Mobile App Platform',
      description: 'White-label mobile apps for subscribers to track their solar production, savings, and environmental impact.'
    },
    {
      icon: Shield,
      title: 'Regulatory Compliance',
      description: 'Built-in compliance tools for virtual net metering, REC tracking, and state-specific regulations.'
    },
    {
      icon: Globe,
      title: 'Multi-Site Management',
      description: 'Manage multiple community solar gardens and microgrids from a single unified platform.'
    }
  ]

  const benefits = [
    {
      metric: '50%',
      description: 'Faster subscriber onboarding'
    },
    {
      metric: '30%',
      description: 'Reduction in billing errors'
    },
    {
      metric: '95%',
      description: 'Subscriber satisfaction rate'
    },
    {
      metric: '24/7',
      description: 'Automated monitoring'
    }
  ]

  const useCases = [
    {
      title: 'Community Solar Gardens',
      description: 'Manage shared solar installations with hundreds of residential and commercial subscribers',
      icon: Home
    },
    {
      title: 'Campus Microgrids',
      description: 'University and corporate campus energy management with resilience and sustainability goals',
      icon: Building2
    },
    {
      title: 'Rural Energy Cooperatives',
      description: 'Enable rural communities to share renewable energy resources and reduce costs',
      icon: Leaf
    }
  ]

  return (
    <div className="min-h-screen">
      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-green-50 to-white py-20 lg:py-32 overflow-hidden">
        <div className="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div className="animate-fade-in">
              <div className="flex items-center mb-6">
                <div className="flex items-center justify-center w-16 h-16 rounded-xl bg-green-100 mr-4">
                  <Grid3X3 className="w-8 h-8 text-green-600" />
                </div>
                <div>
                  <h1 className="text-4xl md:text-5xl font-bold text-gray-900">
                    SolarSaaS GridUnity
                  </h1>
                  <p className="text-xl text-green-600 font-medium">
                    Community Solar & Microgrid Management
                  </p>
                </div>
              </div>
              
              <h2 className="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                Unite communities around shared solar energy
              </h2>
              
              <p className="text-lg text-gray-600 mb-8 leading-relaxed">
                From community solar gardens to campus microgrids, GridUnity provides the complete 
                platform to manage shared renewable energy projects, subscriber relationships, 
                and grid integration seamlessly.
              </p>
              
              <div className="flex flex-col sm:flex-row gap-4">
                <Button size="lg" variant="solar" asChild>
                  <Link href="/contact?product=gridunity">
                    Request Demo
                    <ArrowRight className="ml-2 w-5 h-5" />
                  </Link>
                </Button>
                <Button size="lg" variant="outline" asChild>
                  <Link href="/pricing">View Pricing</Link>
                </Button>
              </div>
            </div>
            
            <div className="relative animate-slide-up">
              <div className="bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">
                <div className="space-y-6">
                  <div className="flex items-center justify-between">
                    <h3 className="font-semibold text-gray-900">Community Solar Dashboard</h3>
                    <div className="flex items-center text-green-600">
                      <div className="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                      <span className="text-sm">Active</span>
                    </div>
                  </div>
                  
                  <div className="grid grid-cols-2 gap-4">
                    <div className="bg-green-50 rounded-lg p-4">
                      <div className="text-2xl font-bold text-green-600">1,247</div>
                      <div className="text-sm text-gray-600">Active Subscribers</div>
                    </div>
                    <div className="bg-blue-50 rounded-lg p-4">
                      <div className="text-2xl font-bold text-blue-600">5.2 MW</div>
                      <div className="text-sm text-gray-600">Total Capacity</div>
                    </div>
                  </div>
                  
                  <div className="space-y-3">
                    <div className="flex items-center justify-between text-sm">
                      <span className="text-gray-600">This Month's Production</span>
                      <span className="text-green-600 font-medium">847 MWh</span>
                    </div>
                    <div className="w-full bg-gray-200 rounded-full h-2">
                      <div className="bg-green-500 h-2 rounded-full" style={{width: '73%'}}></div>
                    </div>
                    <div className="text-xs text-gray-500">73% of monthly target</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              Complete Community Energy Platform
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
              Everything you need to launch and manage successful community solar and microgrid projects
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {features.map((feature, index) => {
              const IconComponent = feature.icon
              return (
                <div
                  key={feature.title}
                  className="bg-white rounded-xl border border-gray-200 p-6 hover-lift animate-slide-up"
                  style={{ animationDelay: `${index * 100}ms` }}
                >
                  <div className="flex items-center justify-center w-12 h-12 rounded-lg bg-green-50 mb-4">
                    <IconComponent className="w-6 h-6 text-green-600" />
                  </div>
                  <h3 className="text-lg font-semibold text-gray-900 mb-3">
                    {feature.title}
                  </h3>
                  <p className="text-gray-600 leading-relaxed">
                    {feature.description}
                  </p>
                </div>
              )
            })}
          </div>
        </div>
      </section>

      {/* Benefits Section */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              Proven Community Impact
            </h2>
            <p className="text-xl text-gray-600">
              See how GridUnity transforms community energy projects
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {benefits.map((benefit, index) => (
              <div
                key={benefit.metric}
                className="text-center animate-slide-up"
                style={{ animationDelay: `${index * 150}ms` }}
              >
                <div className="text-4xl md:text-5xl font-bold text-green-600 mb-2">
                  {benefit.metric}
                </div>
                <p className="text-gray-600 font-medium">
                  {benefit.description}
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Use Cases Section */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              Built for Every Community
            </h2>
            <p className="text-xl text-gray-600">
              From urban neighborhoods to rural cooperatives
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {useCases.map((useCase, index) => {
              const IconComponent = useCase.icon
              return (
                <div
                  key={useCase.title}
                  className="text-center animate-slide-up"
                  style={{ animationDelay: `${index * 200}ms` }}
                >
                  <div className="flex items-center justify-center w-16 h-16 rounded-full solar-gradient mx-auto mb-6">
                    <IconComponent className="w-8 h-8 text-white" />
                  </div>
                  <h3 className="text-xl font-semibold text-gray-900 mb-4">
                    {useCase.title}
                  </h3>
                  <p className="text-gray-600 leading-relaxed">
                    {useCase.description}
                  </p>
                </div>
              )
            })}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 solar-gradient">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            Ready to unite your community around solar?
          </h2>
          <p className="text-xl text-green-100 mb-8">
            Join the movement toward community-owned renewable energy with GridUnity
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button size="xl" variant="secondary" asChild>
              <Link href="/contact?product=gridunity">
                Schedule Demo
                <ArrowRight className="ml-2 w-5 h-5" />
              </Link>
            </Button>
            <Button size="xl" variant="outline" className="border-white text-white hover:bg-white hover:text-green-600" asChild>
              <Link href="/pricing">View Pricing</Link>
            </Button>
          </div>
        </div>
      </section>
    </div>
  )
} 