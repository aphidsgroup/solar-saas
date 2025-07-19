import Link from 'next/link'
import { Button } from '@/components/ui/button'
import { 
  Droplets, 
  Smartphone, 
  MessageSquare, 
  Wifi, 
  BarChart3, 
  Receipt,
  CheckCircle,
  ArrowRight,
  Play
} from 'lucide-react'

export default function IrrigaPayPage() {
  const features = [
    {
      icon: Smartphone,
      title: 'Farmer UPI Billing System',
      description: 'Seamless UPI integration for instant payments with support for all major payment platforms and digital wallets.'
    },
    {
      icon: Droplets,
      title: 'Pump Scheduling & SMS Alerts',
      description: 'Automated pump scheduling based on water needs with SMS notifications for farmers about irrigation cycles.'
    },
    {
      icon: MessageSquare,
      title: 'Multilingual Dashboard',
      description: 'Support for local languages with voice prompts and visual indicators for farmers with varying literacy levels.'
    },
    {
      icon: Wifi,
      title: 'Offline Sync & IoT Meter Data',
      description: 'Works even in areas with poor connectivity, syncing data when connection is restored with IoT meter integration.'
    },
    {
      icon: Receipt,
      title: 'Usage History and Receipts',
      description: 'Detailed usage tracking with digital receipts and payment history accessible via SMS or mobile app.'
    }
  ]

  const useCases = [
    'Solar irrigation providers',
    'Agri-tech companies',
    'Rural energy cooperatives',
    'Water management authorities',
    'Microfinance institutions'
  ]

  return (
    <div className="min-h-screen">
      {/* Hero Banner */}
      <section className="relative bg-gradient-to-br from-cyan-50 to-white py-20 lg:py-32">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div className="animate-fade-in">
              <div className="flex items-center space-x-2 mb-4">
                <div className="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                  <Droplets className="w-6 h-6 text-cyan-600" />
                </div>
                <span className="text-cyan-600 font-semibold">SolarSaaS IrrigaPay</span>
              </div>
              <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                Solar water, made payable.
              </h1>
              <p className="text-xl text-gray-600 mb-8 leading-relaxed">
                The complete billing and management platform for solar irrigation providers. Empower farmers with easy payments, smart scheduling, and transparent usage tracking.
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
              <div className="bg-gradient-to-br from-cyan-100 to-cyan-200 rounded-2xl p-8 aspect-video flex items-center justify-center">
                <div className="text-center">
                  <div className="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <Play className="w-8 h-8 text-cyan-600 ml-1" />
                  </div>
                  <p className="text-cyan-800 font-medium">Watch IrrigaPay Demo</p>
                  <p className="text-cyan-600 text-sm">See farmer-friendly billing</p>
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
              Farmer-First Solar Irrigation Management
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
              Built for rural environments with multilingual support, offline capabilities, and simple payment systems
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
                  <div className="flex items-center justify-center w-12 h-12 rounded-lg bg-cyan-50 mb-4">
                    <IconComponent className="w-6 h-6 text-cyan-600" />
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
                Bridging the Rural Digital Divide
              </h2>
              <div className="space-y-4">
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h3 className="font-semibold text-gray-900">Complex Payment Systems</h3>
                    <p className="text-gray-600">Simple UPI-based payments that work on basic smartphones with multilingual support and voice guidance.</p>
                  </div>
                </div>
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h3 className="font-semibold text-gray-900">Poor Connectivity Issues</h3>
                    <p className="text-gray-600">Offline-first design that works without internet and syncs data when connectivity is available.</p>
                  </div>
                </div>
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h3 className="font-semibold text-gray-900">Language Barriers</h3>
                    <p className="text-gray-600">Native language support with visual indicators and voice prompts for farmers with varying literacy levels.</p>
                  </div>
                </div>
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h3 className="font-semibold text-gray-900">Manual Meter Reading</h3>
                    <p className="text-gray-600">Automated IoT meter integration with SMS-based usage alerts and digital receipt generation.</p>
                  </div>
                </div>
              </div>
            </div>
            
            <div className="bg-white rounded-2xl p-8 shadow-lg">
              <h3 className="text-xl font-semibold text-gray-900 mb-6">Impact on Rural Communities</h3>
              <div className="space-y-6">
                <div className="text-center">
                  <div className="text-3xl font-bold text-cyan-600">85%</div>
                  <div className="text-gray-600">Faster Payment Processing</div>
                </div>
                <div className="text-center">
                  <div className="text-3xl font-bold text-green-600">70%</div>
                  <div className="text-gray-600">Reduction in Payment Disputes</div>
                </div>
                <div className="text-center">
                  <div className="text-3xl font-bold text-purple-600">95%</div>
                  <div className="text-gray-600">Farmer Satisfaction Rate</div>
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
              Built for Rural Solar Irrigation
            </h2>
            <p className="text-xl text-gray-600">
              Designed specifically for these organizations and use cases
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {useCases.map((useCase, index) => (
              <div
                key={useCase}
                className="bg-gradient-to-br from-cyan-50 to-white rounded-xl p-6 border border-cyan-100 animate-slide-up"
                style={{ animationDelay: `${index * 100}ms` }}
              >
                <div className="flex items-center space-x-3">
                  <CheckCircle className="w-6 h-6 text-cyan-600 flex-shrink-0" />
                  <span className="font-medium text-gray-900">{useCase}</span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-gradient-to-br from-cyan-600 to-cyan-700">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            Ready to Empower Rural Communities?
          </h2>
          <p className="text-xl text-cyan-100 mb-8">
            Join organizations making solar irrigation accessible and affordable for farmers
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button size="xl" variant="secondary" asChild>
              <Link href="/contact">
                Request Demo
                <ArrowRight className="ml-2 w-5 h-5" />
              </Link>
            </Button>
            <Button size="xl" variant="outline" className="border-white text-white hover:bg-white hover:text-cyan-600" asChild>
              <Link href="/pricing">See Pricing</Link>
            </Button>
          </div>
        </div>
      </section>
    </div>
  )
} 