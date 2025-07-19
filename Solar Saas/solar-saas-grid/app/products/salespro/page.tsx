import Link from 'next/link'
import { Button } from '@/components/ui/button'
import { 
  BarChart3, 
  Users, 
  FileText, 
  Calculator, 
  PenTool, 
  Package,
  CheckCircle,
  ArrowRight,
  Play
} from 'lucide-react'

export default function SalesProPage() {
  const features = [
    {
      icon: Users,
      title: 'CRM with Lead Funnel Tracking',
      description: 'Track leads from initial contact to closed deals with automated follow-ups and pipeline management.'
    },
    {
      icon: Calculator,
      title: 'Solar Proposal & ROI Generation',
      description: 'Generate professional proposals with accurate ROI calculations, system sizing, and energy production estimates.'
    },
    {
      icon: BarChart3,
      title: 'EMI Simulation & Finance Integration',
      description: 'Integrate with financing partners to offer customers flexible payment options with real-time EMI calculations.'
    },
    {
      icon: PenTool,
      title: 'E-signatures and Digital Paperwork',
      description: 'Streamline contract signing with integrated e-signature capabilities and digital document management.'
    },
    {
      icon: Package,
      title: 'Inventory and Order Workflow Dashboard',
      description: 'Manage equipment inventory, track orders, and coordinate installations from a unified dashboard.'
    }
  ]

  const useCases = [
    'Rooftop solar EPCs and installers',
    'Solar retailers and distributors',
    'Residential solar sales teams',
    'Commercial solar developers',
    'Solar financing companies'
  ]

  return (
    <div className="min-h-screen">
      {/* Hero Banner */}
      <section className="relative bg-gradient-to-br from-blue-50 to-white py-20 lg:py-32">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div className="animate-fade-in">
              <div className="flex items-center space-x-2 mb-4">
                <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                  <BarChart3 className="w-6 h-6 text-blue-600" />
                </div>
                <span className="text-blue-600 font-semibold">SolarSaaS SalesPro</span>
              </div>
              <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                Sell smarter. Close faster. Manage better.
              </h1>
              <p className="text-xl text-gray-600 mb-8 leading-relaxed">
                The complete CRM and sales management platform designed specifically for solar EPCs, installers, and retailers. From lead generation to project completion.
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
              <div className="bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl p-8 aspect-video flex items-center justify-center">
                <div className="text-center">
                  <div className="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <Play className="w-8 h-8 text-blue-600 ml-1" />
                  </div>
                  <p className="text-blue-800 font-medium">Watch SalesPro Demo</p>
                  <p className="text-blue-600 text-sm">See how it works in 3 minutes</p>
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
              Everything You Need to Scale Your Solar Sales
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
              Built specifically for solar professionals who need more than generic CRM tools
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
                  <div className="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-50 mb-4">
                    <IconComponent className="w-6 h-6 text-blue-600" />
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
                Stop Losing Deals to Slow Processes
              </h2>
              <div className="space-y-4">
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h3 className="font-semibold text-gray-900">Manual Proposal Creation</h3>
                    <p className="text-gray-600">Generate professional proposals in minutes, not hours, with automated calculations and customizable templates.</p>
                  </div>
                </div>
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h3 className="font-semibold text-gray-900">Lead Management Chaos</h3>
                    <p className="text-gray-600">Never lose a lead again with automated follow-ups, lead scoring, and pipeline tracking designed for solar sales cycles.</p>
                  </div>
                </div>
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h3 className="font-semibold text-gray-900">Financing Complexity</h3>
                    <p className="text-gray-600">Integrate with major solar financing partners to offer customers instant financing options and EMI calculations.</p>
                  </div>
                </div>
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h3 className="font-semibold text-gray-900">Project Coordination</h3>
                    <p className="text-gray-600">Seamlessly coordinate from sale to installation with integrated project management and inventory tracking.</p>
                  </div>
                </div>
              </div>
            </div>
            
            <div className="bg-white rounded-2xl p-8 shadow-lg">
              <h3 className="text-xl font-semibold text-gray-900 mb-6">Results Our Customers See</h3>
              <div className="space-y-6">
                <div className="text-center">
                  <div className="text-3xl font-bold text-blue-600">40%</div>
                  <div className="text-gray-600">Higher Close Rate</div>
                </div>
                <div className="text-center">
                  <div className="text-3xl font-bold text-green-600">50%</div>
                  <div className="text-gray-600">Faster Proposals</div>
                </div>
                <div className="text-center">
                  <div className="text-3xl font-bold text-purple-600">60%</div>
                  <div className="text-gray-600">Less Admin Time</div>
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
              Perfect for Solar Sales Teams
            </h2>
            <p className="text-xl text-gray-600">
              Designed specifically for these solar business models
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {useCases.map((useCase, index) => (
              <div
                key={useCase}
                className="bg-gradient-to-br from-blue-50 to-white rounded-xl p-6 border border-blue-100 animate-slide-up"
                style={{ animationDelay: `${index * 100}ms` }}
              >
                <div className="flex items-center space-x-3">
                  <CheckCircle className="w-6 h-6 text-blue-600 flex-shrink-0" />
                  <span className="font-medium text-gray-900">{useCase}</span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-gradient-to-br from-blue-600 to-blue-700">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            Ready to Transform Your Solar Sales?
          </h2>
          <p className="text-xl text-blue-100 mb-8">
            Join hundreds of solar professionals who've already upgraded their sales process
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button size="xl" variant="secondary" asChild>
              <Link href="/contact">
                Request Demo
                <ArrowRight className="ml-2 w-5 h-5" />
              </Link>
            </Button>
            <Button size="xl" variant="outline" className="border-white text-white hover:bg-white hover:text-blue-600" asChild>
              <Link href="/pricing">See Pricing</Link>
            </Button>
          </div>
        </div>
      </section>
    </div>
  )
} 