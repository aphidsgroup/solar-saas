import Link from 'next/link'
import { Button } from '@/components/ui/button'
import { 
  Zap, 
  FileText, 
  DollarSign, 
  BarChart, 
  Users, 
  Shield,
  CheckCircle,
  ArrowRight,
  Play
} from 'lucide-react'

export default function PPAFlowPage() {
  const features = [
    {
      icon: FileText,
      title: 'Smart PPA Contract Management',
      description: 'Automated contract generation, version control, and lifecycle management for all your power purchase agreements.'
    },
    {
      icon: DollarSign,
      title: 'Energy-based Dynamic Billing',
      description: 'Automated billing based on actual energy production with real-time meter data integration and invoice generation.'
    },
    {
      icon: Shield,
      title: 'SLA and Asset Uptime Tracking',
      description: 'Monitor system performance against SLA commitments with automated alerts and performance guarantees.'
    },
    {
      icon: BarChart,
      title: 'Performance Dashboards',
      description: 'Real-time analytics and reporting for energy production, financial performance, and customer satisfaction.'
    },
    {
      icon: Users,
      title: 'Customer Self-Service Portal',
      description: 'Give customers access to their energy data, billing history, and performance metrics through a branded portal.'
    }
  ]

  const useCases = [
    'RESCO/OPEX model providers',
    'Solar leasing companies',
    'Independent power producers (IPPs)',
    'Commercial solar developers',
    'Utility-scale project operators'
  ]

  return (
    <div className="min-h-screen">
      {/* Hero Banner */}
      <section className="relative bg-gradient-to-br from-yellow-50 to-white py-20 lg:py-32">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div className="animate-fade-in">
              <div className="flex items-center space-x-2 mb-4">
                <div className="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                  <Zap className="w-6 h-6 text-yellow-600" />
                </div>
                <span className="text-yellow-600 font-semibold">SolarSaaS PPAFlow</span>
              </div>
              <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                Automate your power purchase lifecycle.
              </h1>
              <p className="text-xl text-gray-600 mb-8 leading-relaxed">
                The complete PPA management platform for RESCO, OPEX, and leasing providers. From contract creation to energy billing and customer management.
              </p>
              <div className="flex flex-col sm:flex-row gap-4">
                <Button size="xl" variant="solar" asChild>
                  <Link href="/contact">
                    Request Demo
                    <ArrowRight className="ml-2 w-5 h-5" />
                  </Link>
                </Button>
                <Button size="xl" variant="outline" asChild>
                  <Link href="/pricing">See Pricing</Link>
                </Button>
              </div>
            </div>
            
            {/* Demo Video Placeholder */}
            <div className="relative animate-slide-up">
              <div className="bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-2xl p-8 aspect-video flex items-center justify-center">
                <div className="text-center">
                  <div className="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <Play className="w-8 h-8 text-yellow-600 ml-1" />
                  </div>
                  <p className="text-yellow-800 font-medium">Watch PPAFlow Demo</p>
                  <p className="text-yellow-600 text-sm">See automated PPA management</p>
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
              Complete PPA Lifecycle Management
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
              From contract signing to energy billing - everything you need to manage power purchase agreements
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
                  <div className="flex items-center justify-center w-12 h-12 rounded-lg bg-yellow-50 mb-4">
                    <IconComponent className="w-6 h-6 text-yellow-600" />
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

      {/* Problem Solved Section */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
              <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                Eliminate PPA Management Headaches
              </h2>
              <div className="space-y-4">
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h3 className="font-semibold text-gray-900">Manual Contract Tracking</h3>
                    <p className="text-gray-600">Automate contract lifecycle management with version control, renewal alerts, and compliance tracking.</p>
                  </div>
                </div>
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h3 className="font-semibold text-gray-900">Complex Energy Billing</h3>
                    <p className="text-gray-600">Generate accurate bills based on actual energy production with automated meter data collection and processing.</p>
                  </div>
                </div>
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h3 className="font-semibold text-gray-900">Performance Monitoring</h3>
                    <p className="text-gray-600">Track system performance against SLA commitments with real-time monitoring and automated reporting.</p>
                  </div>
                </div>
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h3 className="font-semibold text-gray-900">Customer Communication</h3>
                    <p className="text-gray-600">Provide customers with transparent access to their energy data and billing through self-service portals.</p>
                  </div>
                </div>
              </div>
            </div>
            
            <div className="bg-white rounded-2xl p-8 shadow-lg">
              <h3 className="text-xl font-semibold text-gray-900 mb-6">Impact on Your Business</h3>
              <div className="space-y-6">
                <div className="text-center">
                  <div className="text-3xl font-bold text-yellow-600">75%</div>
                  <div className="text-gray-600">Faster Billing Process</div>
                </div>
                <div className="text-center">
                  <div className="text-3xl font-bold text-green-600">90%</div>
                  <div className="text-gray-600">Billing Accuracy</div>
                </div>
                <div className="text-center">
                  <div className="text-3xl font-bold text-purple-600">50%</div>
                  <div className="text-gray-600">Less Admin Overhead</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Ideal Use Cases Section */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              Built for PPA Providers
            </h2>
            <p className="text-xl text-gray-600">
              Designed specifically for these business models
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {useCases.map((useCase, index) => (
              <div
                key={useCase}
                className="bg-gradient-to-br from-yellow-50 to-white rounded-xl p-6 border border-yellow-100 animate-slide-up"
                style={{ animationDelay: `${index * 100}ms` }}
              >
                <div className="flex items-center space-x-3">
                  <CheckCircle className="w-6 h-6 text-yellow-600 flex-shrink-0" />
                  <span className="font-medium text-gray-900">{useCase}</span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-gradient-to-br from-yellow-600 to-yellow-700">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            Ready to Automate Your PPA Operations?
          </h2>
          <p className="text-xl text-yellow-100 mb-8">
            Join leading PPA providers who've streamlined their operations with PPAFlow
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button size="xl" variant="secondary" asChild>
              <Link href="/contact">
                Request Demo
                <ArrowRight className="ml-2 w-5 h-5" />
              </Link>
            </Button>
            <Button size="xl" variant="outline" className="border-white text-white hover:bg-white hover:text-yellow-600" asChild>
              <Link href="/pricing">See Pricing</Link>
            </Button>
          </div>
        </div>
      </section>
    </div>
  )
} 