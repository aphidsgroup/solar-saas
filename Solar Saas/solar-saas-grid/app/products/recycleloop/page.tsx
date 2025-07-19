import Link from 'next/link'
import { Button } from '@/components/ui/button'
import { 
  Recycle, 
  Leaf, 
  BarChart3, 
  Shield, 
  Truck, 
  FileText, 
  CheckCircle, 
  ArrowRight,
  Globe,
  Award,
  Clock,
  Users
} from 'lucide-react'
import { Metadata } from 'next'

export const metadata: Metadata = {
  title: 'RecycleLoop - Solar Panel Recycling & Tracking | SolarSaaS Grid',
  description: 'End-of-life solar panel tracking and recycling management with compliance reporting and circular economy optimization.',
  keywords: 'solar recycling, panel disposal, circular economy, solar waste management, sustainability tracking',
}

export default function RecycleLoopPage() {
  const features = [
    {
      icon: BarChart3,
      title: 'Lifecycle Tracking',
      description: 'Track every solar panel from installation to end-of-life with comprehensive asset management and predictive analytics.'
    },
    {
      icon: Truck,
      title: 'Logistics Management',
      description: 'Coordinate collection, transportation, and processing with certified recycling partners across your region.'
    },
    {
      icon: Recycle,
      title: 'Material Recovery',
      description: 'Maximize material recovery rates with AI-optimized sorting and processing recommendations.'
    },
    {
      icon: FileText,
      title: 'Compliance Reporting',
      description: 'Automated regulatory reporting for WEEE, RoHS, and local environmental compliance requirements.'
    },
    {
      icon: Shield,
      title: 'Chain of Custody',
      description: 'Maintain complete chain of custody documentation with blockchain-verified tracking and certificates.'
    },
    {
      icon: Globe,
      title: 'Impact Analytics',
      description: 'Measure and report environmental impact, carbon footprint reduction, and circular economy contributions.'
    }
  ]

  const benefits = [
    {
      metric: '95%',
      description: 'Material recovery rate'
    },
    {
      metric: '100%',
      description: 'Compliance guarantee'
    },
    {
      metric: '60%',
      description: 'Cost reduction vs. landfill'
    },
    {
      metric: '24/7',
      description: 'Tracking visibility'
    }
  ]

  const useCases = [
    {
      title: 'Solar Installers & EPCs',
      description: 'Manage warranty replacements and end-of-life panels with full compliance tracking',
      icon: Users
    },
    {
      title: 'Utility-Scale Operators',
      description: 'Plan and execute large-scale decommissioning projects with optimized logistics',
      icon: Award
    },
    {
      title: 'Recycling Facilities',
      description: 'Streamline intake, processing, and material sales with integrated workflow management',
      icon: Clock
    }
  ]

  return (
    <div className="min-h-screen">
      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-emerald-50 to-white py-20 lg:py-32 overflow-hidden">
        <div className="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div className="animate-fade-in">
              <div className="flex items-center mb-6">
                <div className="flex items-center justify-center w-16 h-16 rounded-xl bg-emerald-100 mr-4">
                  <Recycle className="w-8 h-8 text-emerald-600" />
                </div>
                <div>
                  <h1 className="text-4xl md:text-5xl font-bold text-gray-900">
                    SolarSaaS RecycleLoop
                  </h1>
                  <p className="text-xl text-emerald-600 font-medium">
                    Solar Panel Recycling & Tracking
                  </p>
                </div>
              </div>
              
              <h2 className="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                Close the loop on solar sustainability
              </h2>
              
              <p className="text-lg text-gray-600 mb-8 leading-relaxed">
                As the first generation of solar panels reaches end-of-life, RecycleLoop provides 
                the comprehensive platform to track, collect, and recycle solar panels responsibly 
                while maximizing material recovery and ensuring regulatory compliance.
              </p>
              
              <div className="flex flex-col sm:flex-row gap-4">
                <Button size="lg" variant="solar" asChild>
                  <Link href="/contact?product=recycleloop">
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
                    <h3 className="font-semibold text-gray-900">Recycling Dashboard</h3>
                    <div className="flex items-center text-emerald-600">
                      <div className="w-2 h-2 bg-emerald-500 rounded-full mr-2"></div>
                      <span className="text-sm">Processing</span>
                    </div>
                  </div>
                  
                  <div className="grid grid-cols-2 gap-4">
                    <div className="bg-emerald-50 rounded-lg p-4">
                      <div className="text-2xl font-bold text-emerald-600">12,847</div>
                      <div className="text-sm text-gray-600">Panels Processed</div>
                    </div>
                    <div className="bg-blue-50 rounded-lg p-4">
                      <div className="text-2xl font-bold text-blue-600">94.7%</div>
                      <div className="text-sm text-gray-600">Recovery Rate</div>
                    </div>
                  </div>
                  
                  <div className="space-y-3">
                    <div className="flex items-center justify-between text-sm">
                      <span className="text-gray-600">Materials Recovered</span>
                      <span className="text-emerald-600 font-medium">847 tons</span>
                    </div>
                    <div className="space-y-2">
                      <div className="flex justify-between text-xs">
                        <span>Glass</span>
                        <span>76%</span>
                      </div>
                      <div className="w-full bg-gray-200 rounded-full h-1.5">
                        <div className="bg-emerald-500 h-1.5 rounded-full" style={{width: '76%'}}></div>
                      </div>
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
              Complete Recycling Ecosystem
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
              From tracking to processing, everything you need for responsible solar panel recycling
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
                  <div className="flex items-center justify-center w-12 h-12 rounded-lg bg-emerald-50 mb-4">
                    <IconComponent className="w-6 h-6 text-emerald-600" />
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
              Sustainable Results
            </h2>
            <p className="text-xl text-gray-600">
              See the environmental and economic impact of responsible recycling
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {benefits.map((benefit, index) => (
              <div
                key={benefit.metric}
                className="text-center animate-slide-up"
                style={{ animationDelay: `${index * 150}ms` }}
              >
                <div className="text-4xl md:text-5xl font-bold text-emerald-600 mb-2">
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
              Built for Every Stakeholder
            </h2>
            <p className="text-xl text-gray-600">
              From installers to recyclers, everyone benefits
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
                  <div className="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 mx-auto mb-6">
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
      <section className="py-20 bg-gradient-to-br from-emerald-600 to-emerald-700">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            Ready to close the solar sustainability loop?
          </h2>
          <p className="text-xl text-emerald-100 mb-8">
            Join the circular economy movement with responsible solar panel recycling
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button size="xl" variant="secondary" asChild>
              <Link href="/contact?product=recycleloop">
                Schedule Demo
                <ArrowRight className="ml-2 w-5 h-5" />
              </Link>
            </Button>
            <Button size="xl" variant="outline" className="border-white text-white hover:bg-white hover:text-emerald-600" asChild>
              <Link href="/pricing">View Pricing</Link>
            </Button>
          </div>
        </div>
      </section>
    </div>
  )
} 