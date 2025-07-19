import Link from 'next/link'
import { Button } from '@/components/ui/button'
import { 
  Share2, 
  Building, 
  DollarSign, 
  Shield, 
  BarChart3, 
  Smartphone, 
  CheckCircle, 
  ArrowRight,
  Users,
  Zap,
  TrendingUp,
  Globe
} from 'lucide-react'
import { Metadata } from 'next'

export const metadata: Metadata = {
  title: 'ShareX - Digital Solar Ownership Platform | SolarSaaS Grid',
  description: 'Enable MSMEs to own and share solar assets digitally with fractional ownership, automated returns, and transparent tracking.',
  keywords: 'solar ownership, fractional solar, MSME solar, digital solar assets, solar investment platform',
}

export default function ShareXPage() {
  const features = [
    {
      icon: Share2,
      title: 'Fractional Ownership',
      description: 'Enable multiple MSMEs to co-own solar installations with transparent ownership tracking and automated profit sharing.'
    },
    {
      icon: DollarSign,
      title: 'Automated Returns',
      description: 'Distribute solar energy savings and revenue automatically based on ownership percentages and consumption patterns.'
    },
    {
      icon: BarChart3,
      title: 'Performance Analytics',
      description: 'Real-time tracking of solar production, financial returns, and environmental impact for all stakeholders.'
    },
    {
      icon: Shield,
      title: 'Smart Contracts',
      description: 'Blockchain-based smart contracts ensure transparent, automated, and secure ownership and payment distribution.'
    },
    {
      icon: Smartphone,
      title: 'Mobile Dashboard',
      description: 'User-friendly mobile app for MSMEs to track their solar investments, returns, and energy consumption.'
    },
    {
      icon: Globe,
      title: 'Multi-Site Management',
      description: 'Manage multiple shared solar installations across different locations with unified reporting and analytics.'
    }
  ]

  const benefits = [
    {
      metric: '70%',
      description: 'Lower upfront investment'
    },
    {
      metric: '15%',
      description: 'Average annual returns'
    },
    {
      metric: '90%',
      description: 'Reduction in energy costs'
    },
    {
      metric: '100%',
      description: 'Transparent tracking'
    }
  ]

  const useCases = [
    {
      title: 'Industrial Parks',
      description: 'Enable multiple small manufacturers to share rooftop solar installations and reduce energy costs',
      icon: Building
    },
    {
      title: 'Commercial Complexes',
      description: 'Allow retail businesses and offices to co-invest in shared solar infrastructure',
      icon: Users
    },
    {
      title: 'Agricultural Cooperatives',
      description: 'Help farming cooperatives share solar irrigation and processing facility costs',
      icon: Zap
    }
  ]

  return (
    <div className="min-h-screen">
      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-orange-50 to-white py-20 lg:py-32 overflow-hidden">
        <div className="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div className="animate-fade-in">
              <div className="flex items-center mb-6">
                <div className="flex items-center justify-center w-16 h-16 rounded-xl bg-orange-100 mr-4">
                  <Share2 className="w-8 h-8 text-orange-600" />
                </div>
                <div>
                  <h1 className="text-4xl md:text-5xl font-bold text-gray-900">
                    SolarSaaS ShareX
                  </h1>
                  <p className="text-xl text-orange-600 font-medium">
                    Digital Solar Ownership Platform
                  </p>
                </div>
              </div>
              
              <h2 className="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                Democratize solar ownership for MSMEs
              </h2>
              
              <p className="text-lg text-gray-600 mb-8 leading-relaxed">
                ShareX enables micro, small, and medium enterprises to access solar energy through 
                fractional ownership, shared investments, and digital asset management. Make solar 
                affordable and accessible for businesses of all sizes.
              </p>
              
              <div className="flex flex-col sm:flex-row gap-4">
                <Button size="lg" variant="solar" asChild>
                  <Link href="/contact?product=sharex">
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
                    <h3 className="font-semibold text-gray-900">Ownership Dashboard</h3>
                    <div className="flex items-center text-orange-600">
                      <div className="w-2 h-2 bg-orange-500 rounded-full mr-2"></div>
                      <span className="text-sm">Active</span>
                    </div>
                  </div>
                  
                  <div className="grid grid-cols-2 gap-4">
                    <div className="bg-orange-50 rounded-lg p-4">
                      <div className="text-2xl font-bold text-orange-600">₹2.4L</div>
                      <div className="text-sm text-gray-600">Your Investment</div>
                    </div>
                    <div className="bg-green-50 rounded-lg p-4">
                      <div className="text-2xl font-bold text-green-600">₹47K</div>
                      <div className="text-sm text-gray-600">Returns YTD</div>
                    </div>
                  </div>
                  
                  <div className="space-y-3">
                    <div className="flex items-center justify-between text-sm">
                      <span className="text-gray-600">Your Ownership Share</span>
                      <span className="text-orange-600 font-medium">12.5%</span>
                    </div>
                    <div className="w-full bg-gray-200 rounded-full h-2">
                      <div className="bg-orange-500 h-2 rounded-full" style={{width: '12.5%'}}></div>
                    </div>
                    <div className="text-xs text-gray-500">of 500kW installation</div>
                  </div>
                  
                  <div className="pt-4 border-t border-gray-100">
                    <div className="flex items-center justify-between text-sm">
                      <span className="text-gray-600">Monthly Savings</span>
                      <span className="text-green-600 font-medium">₹8,750</span>
                    </div>
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
              Complete Digital Ownership Platform
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
              Everything MSMEs need to invest in, own, and benefit from solar energy assets
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
                  <div className="flex items-center justify-center w-12 h-12 rounded-lg bg-orange-50 mb-4">
                    <IconComponent className="w-6 h-6 text-orange-600" />
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
              Proven MSME Benefits
            </h2>
            <p className="text-xl text-gray-600">
              See how ShareX transforms solar access for small businesses
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {benefits.map((benefit, index) => (
              <div
                key={benefit.metric}
                className="text-center animate-slide-up"
                style={{ animationDelay: `${index * 150}ms` }}
              >
                <div className="text-4xl md:text-5xl font-bold text-orange-600 mb-2">
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
              Perfect for Every Business Cluster
            </h2>
            <p className="text-xl text-gray-600">
              From industrial parks to commercial complexes
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
                  <div className="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 mx-auto mb-6">
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
      <section className="py-20 bg-gradient-to-br from-orange-600 to-orange-700">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            Ready to democratize solar ownership?
          </h2>
          <p className="text-xl text-orange-100 mb-8">
            Help MSMEs access clean energy through shared solar investments with ShareX
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button size="xl" variant="secondary" asChild>
              <Link href="/contact?product=sharex">
                Schedule Demo
                <ArrowRight className="ml-2 w-5 h-5" />
              </Link>
            </Button>
            <Button size="xl" variant="outline" className="border-white text-white hover:bg-white hover:text-orange-600" asChild>
              <Link href="/pricing">View Pricing</Link>
            </Button>
          </div>
        </div>
      </section>
    </div>
  )
} 