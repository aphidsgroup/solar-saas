import Link from 'next/link'
import { Button } from '@/components/ui/button'
import { 
  Home, 
  Smartphone, 
  Zap, 
  Shield, 
  BarChart3, 
  Wifi, 
  CheckCircle, 
  ArrowRight,
  Thermometer,
  Lightbulb,
  Battery,
  Settings
} from 'lucide-react'
import { Metadata } from 'next'

export const metadata: Metadata = {
  title: 'SmartOS - Solar Smart Home Operating System | SolarSaaS Grid',
  description: 'Complete operating system for solar smart homes and buildings with energy management, automation, and intelligent optimization.',
  keywords: 'smart home solar, home energy management, solar automation, intelligent buildings, IoT solar',
}

export default function SmartOSPage() {
  const features = [
    {
      icon: Zap,
      title: 'Energy Orchestration',
      description: 'Intelligently manage solar production, battery storage, and home consumption with AI-powered optimization algorithms.'
    },
    {
      icon: Smartphone,
      title: 'Unified Control Hub',
      description: 'Single interface to control all solar, storage, HVAC, lighting, and smart appliances from anywhere.'
    },
    {
      icon: BarChart3,
      title: 'Predictive Analytics',
      description: 'Machine learning algorithms predict energy needs, weather patterns, and optimize system performance automatically.'
    },
    {
      icon: Shield,
      title: 'Grid Integration',
      description: 'Seamless grid-tie functionality with automatic islanding, peak shaving, and demand response capabilities.'
    },
    {
      icon: Wifi,
      title: 'IoT Ecosystem',
      description: 'Connect and control thousands of smart devices with open APIs and industry-standard protocols.'
    },
    {
      icon: Settings,
      title: 'Automated Optimization',
      description: 'Continuous learning and adjustment to maximize energy savings, comfort, and system longevity.'
    }
  ]

  const benefits = [
    {
      metric: '40%',
      description: 'Energy cost reduction'
    },
    {
      metric: '25%',
      description: 'Increased solar utilization'
    },
    {
      metric: '99.9%',
      description: 'System uptime'
    },
    {
      metric: '24/7',
      description: 'Intelligent monitoring'
    }
  ]

  const useCases = [
    {
      title: 'Residential Solar Homes',
      description: 'Complete home energy management for solar-powered residences with smart automation',
      icon: Home
    },
    {
      title: 'Commercial Buildings',
      description: 'Intelligent building management systems for offices, retail, and mixed-use developments',
      icon: Settings
    },
    {
      title: 'Multi-Family Housing',
      description: 'Centralized energy management for apartments, condos, and housing communities',
      icon: Battery
    }
  ]

  return (
    <div className="min-h-screen">
      {/* Hero Section */}
      <section className="relative bg-gradient-to-br from-indigo-50 to-white py-20 lg:py-32 overflow-hidden">
        <div className="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div className="animate-fade-in">
              <div className="flex items-center mb-6">
                <div className="flex items-center justify-center w-16 h-16 rounded-xl bg-indigo-100 mr-4">
                  <Home className="w-8 h-8 text-indigo-600" />
                </div>
                <div>
                  <h1 className="text-4xl md:text-5xl font-bold text-gray-900">
                    SolarSaaS SmartOS
                  </h1>
                  <p className="text-xl text-indigo-600 font-medium">
                    Solar Smart Home Operating System
                  </p>
                </div>
              </div>
              
              <h2 className="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                The brain behind intelligent solar homes
              </h2>
              
              <p className="text-lg text-gray-600 mb-8 leading-relaxed">
                SmartOS is the comprehensive operating system that transforms any building into 
                an intelligent, energy-optimized environment. Seamlessly integrate solar, storage, 
                smart devices, and automation for maximum efficiency and comfort.
              </p>
              
              <div className="flex flex-col sm:flex-row gap-4">
                <Button size="lg" variant="solar" asChild>
                  <Link href="/contact?product=smartos">
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
                    <h3 className="font-semibold text-gray-900">Smart Home Control</h3>
                    <div className="flex items-center text-indigo-600">
                      <div className="w-2 h-2 bg-indigo-500 rounded-full mr-2"></div>
                      <span className="text-sm">Connected</span>
                    </div>
                  </div>
                  
                  <div className="grid grid-cols-2 gap-4">
                    <div className="bg-green-50 rounded-lg p-4">
                      <div className="flex items-center mb-2">
                        <Zap className="w-4 h-4 text-green-600 mr-2" />
                        <span className="text-sm text-gray-600">Solar</span>
                      </div>
                      <div className="text-xl font-bold text-green-600">8.2 kW</div>
                    </div>
                    <div className="bg-blue-50 rounded-lg p-4">
                      <div className="flex items-center mb-2">
                        <Battery className="w-4 h-4 text-blue-600 mr-2" />
                        <span className="text-sm text-gray-600">Battery</span>
                      </div>
                      <div className="text-xl font-bold text-blue-600">87%</div>
                    </div>
                  </div>
                  
                  <div className="space-y-3">
                    <div className="flex items-center justify-between">
                      <div className="flex items-center">
                        <Thermometer className="w-4 h-4 text-gray-400 mr-2" />
                        <span className="text-sm text-gray-600">Temperature</span>
                      </div>
                      <span className="text-sm font-medium">72°F</span>
                    </div>
                    <div className="flex items-center justify-between">
                      <div className="flex items-center">
                        <Lightbulb className="w-4 h-4 text-gray-400 mr-2" />
                        <span className="text-sm text-gray-600">Lighting</span>
                      </div>
                      <span className="text-sm font-medium text-green-600">Auto</span>
                    </div>
                  </div>
                  
                  <div className="pt-4 border-t border-gray-100">
                    <div className="text-center">
                      <div className="text-2xl font-bold text-indigo-600">$47</div>
                      <div className="text-sm text-gray-600">Saved this month</div>
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
              Complete Smart Home Intelligence
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
              Everything you need to create the most intelligent, efficient solar-powered buildings
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
                  <div className="flex items-center justify-center w-12 h-12 rounded-lg bg-indigo-50 mb-4">
                    <IconComponent className="w-6 h-6 text-indigo-600" />
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
              Intelligent Results
            </h2>
            <p className="text-xl text-gray-600">
              See the impact of truly intelligent solar home automation
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {benefits.map((benefit, index) => (
              <div
                key={benefit.metric}
                className="text-center animate-slide-up"
                style={{ animationDelay: `${index * 150}ms` }}
              >
                <div className="text-4xl md:text-5xl font-bold text-indigo-600 mb-2">
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
              Built for Every Building Type
            </h2>
            <p className="text-xl text-gray-600">
              From single homes to large commercial buildings
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
                  <div className="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 mx-auto mb-6">
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
      <section className="py-20 bg-gradient-to-br from-indigo-600 to-indigo-700">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
            Ready to build the smartest solar home?
          </h2>
          <p className="text-xl text-indigo-100 mb-8">
            Transform any building into an intelligent, energy-optimized environment with SmartOS
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button size="xl" variant="secondary" asChild>
              <Link href="/contact?product=smartos">
                Schedule Demo
                <ArrowRight className="ml-2 w-5 h-5" />
              </Link>
            </Button>
            <Button size="xl" variant="outline" className="border-white text-white hover:bg-white hover:text-indigo-600" asChild>
              <Link href="/pricing">View Pricing</Link>
            </Button>
          </div>
        </div>
      </section>
    </div>
  )
} 