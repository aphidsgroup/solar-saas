import Link from 'next/link'
import { Button } from '@/components/ui/button'
import { 
  Building, 
  BarChart3, 
  Zap, 
  Shield, 
  Users, 
  Clock, 
  CheckCircle, 
  ArrowRight,
  TrendingUp,
  AlertTriangle,
  Settings,
  Database
} from 'lucide-react'
import { Metadata } from 'next'

export const metadata: Metadata = {
  title: 'ParkOps - Utility-Scale Solar Park Operations | SolarSaaS Grid',
  description: 'Operate utility-scale solar parks like clockwork with automated monitoring, predictive maintenance, and performance optimization.',
  keywords: 'utility solar, solar park operations, solar farm management, renewable energy operations, solar monitoring',
}

export default function ParkOpsPage() {
  const features = [
    {
      icon: BarChart3,
      title: 'Real-Time Performance Monitoring',
      description: 'Monitor every inverter, panel, and system component with millisecond precision across your entire solar park.'
    },
    {
      icon: AlertTriangle,
      title: 'Predictive Maintenance',
      description: 'AI-powered algorithms predict equipment failures before they happen, minimizing downtime and maximizing ROI.'
    },
    {
      icon: TrendingUp,
      title: 'Yield Optimization',
      description: 'Maximize energy production with intelligent tracking, cleaning schedules, and performance benchmarking.'
    },
    {
      icon: Shield,
      title: 'Compliance & Reporting',
      description: 'Automated regulatory reporting, environmental compliance tracking, and audit-ready documentation.'
    },
    {
      icon: Users,
      title: 'Team Coordination',
      description: 'Coordinate field teams, contractors, and remote operations with integrated communication tools.'
    },
    {
      icon: Database,
      title: 'Asset Management',
      description: 'Complete lifecycle tracking of all equipment, warranties, and maintenance schedules in one platform.'
    }
  ]

  const benefits = [
    {
      metric: '15%',
      description: 'Average increase in energy yield'
    },
    {
      metric: '40%',
      description: 'Reduction in unplanned downtime'
    },
    {
      metric: '25%',
      description: 'Lower O&M costs'
    },
    {
      metric: '99.9%',
      description: 'System uptime guarantee'
    }
  ]

  const useCases = [
    {
      title: 'Utility-Scale Solar Farms',
      description: 'Manage multi-MW installations with thousands of components',
      icon: Building
    },
    {
      title: 'Solar + Storage Projects',
      description: 'Coordinate solar generation with battery storage systems',
      icon: Zap
    },
    {
      title: 'Agrivoltaics Operations',
      description: 'Balance solar production with agricultural activities',
      icon: Settings
    }
  ]

  return (
    <div className="min-h-screen">
      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-purple-50 to-white py-20 lg:py-32 overflow-hidden">
        <div className="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div className="animate-fade-in">
              <div className="flex items-center mb-6">
                <div className="flex items-center justify-center w-16 h-16 rounded-xl bg-purple-100 mr-4">
                  <Building className="w-8 h-8 text-purple-600" />
                </div>
                <div>
                  <h1 className="text-4xl md:text-5xl font-bold text-gray-900">
                    SolarSaaS ParkOps
                  </h1>
                  <p className="text-xl text-purple-600 font-medium">
                    Utility-Scale Solar Park Operations
                  </p>
                </div>
              </div>
              
              <h2 className="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                Operate utility-scale solar parks like clockwork
              </h2>
              
              <p className="text-lg text-gray-600 mb-8 leading-relaxed">
                From 10MW to 1GW+ installations, ParkOps provides the comprehensive operations platform 
                you need to maximize performance, minimize costs, and ensure regulatory compliance across 
                your entire solar portfolio.
              </p>
              
              <div className="flex flex-col sm:flex-row gap-4">
                <Button size="lg" variant="solar" asChild>
                  <Link href="/contact?product=parkops">
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
                    <h3 className="font-semibold text-gray-900">Solar Park Dashboard</h3>
                    <div className="flex items-center text-green-600">
                      <div className="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                      <span className="text-sm">Online</span>
                    </div>
                  </div>
                  
                  <div className="grid grid-cols-2 gap-4">
                    <div className="bg-green-50 rounded-lg p-4">
                      <div className="text-2xl font-bold text-green-600">847.2 MW</div>
                      <div className="text-sm text-gray-600">Current Output</div>
                    </div>
                    <div className="bg-blue-50 rounded-lg p-4">
                      <div className="text-2xl font-bold text-blue-600">99.7%</div>
                      <div className="text-sm text-gray-600">System Availability</div>
                    </div>
                  </div>
                  
                  <div className="space-y-3">
                    <div className="flex items-center justify-between text-sm">
                      <span className="text-gray-600">Inverter Status</span>
                      <span className="text-green-600 font-medium">247/250 Online</span>
                    </div>
                    <div className="w-full bg-gray-200 rounded-full h-2">
                      <div className="bg-green-500 h-2 rounded-full" style={{width: '98.8%'}}></div>
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
              Complete Operations Management
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
              Everything you need to operate utility-scale solar installations efficiently and profitably
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
                  <div className="flex items-center justify-center w-12 h-12 rounded-lg bg-purple-50 mb-4">
                    <IconComponent className="w-6 h-6 text-purple-600" />
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
              Proven Results
            </h2>
            <p className="text-xl text-gray-600">
              See the impact ParkOps has on utility-scale solar operations
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {benefits.map((benefit, index) => (
              <div
                key={benefit.metric}
                className="text-center animate-slide-up"
                style={{ animationDelay: `${index * 150}ms` }}
              >
                <div className="text-4xl md:text-5xl font-bold text-purple-600 mb-2">
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
              Built for Every Scale
            </h2>
            <p className="text-xl text-gray-600">
              From single installations to multi-site portfolios
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
                  <div className="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 mx-auto mb-6">
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
      <section className="py-20 bg-gradient-to-br from-purple-600 to-purple-700">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            Ready to optimize your solar park operations?
          </h2>
          <p className="text-xl text-purple-100 mb-8">
            Join leading utility-scale solar operators who trust ParkOps to maximize their performance
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button size="xl" variant="secondary" asChild>
              <Link href="/contact?product=parkops">
                Schedule Demo
                <ArrowRight className="ml-2 w-5 h-5" />
              </Link>
            </Button>
            <Button size="xl" variant="outline" className="border-white text-white hover:bg-white hover:text-purple-600" asChild>
              <Link href="/pricing">View Pricing</Link>
            </Button>
          </div>
        </div>
      </section>
    </div>
  )
} 