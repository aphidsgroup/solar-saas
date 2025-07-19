'use client'

import { useState } from 'react'
import Link from 'next/link'
import { Button } from '@/components/ui/button'
import { 
  Check, 
  X, 
  ArrowRight,
  BarChart3,
  Zap,
  Building,
  Droplets,
  Grid3X3,
  Recycle,
  Share2,
  Home
} from 'lucide-react'

export default function PricingPage() {
  const [isAnnual, setIsAnnual] = useState(false)

  const products = [
    {
      name: 'SalesPro',
      icon: BarChart3,
      description: 'CRM & Sales Management',
      monthlyPrice: 99,
      annualPrice: 990,
      features: ['Lead Management', 'Proposal Generation', 'EMI Calculator', 'E-signatures', 'Basic Reporting'],
      premiumFeatures: ['Advanced Analytics', 'Custom Integrations', 'White-label Portal', 'Priority Support']
    },
    {
      name: 'PPAFlow',
      icon: Zap,
      description: 'PPA Lifecycle Management',
      monthlyPrice: 149,
      annualPrice: 1490,
      features: ['Contract Management', 'Energy Billing', 'Performance Tracking', 'Customer Portal', 'Basic Reports'],
      premiumFeatures: ['Advanced SLA Monitoring', 'Custom Billing Rules', 'API Access', 'Dedicated Support']
    },
    {
      name: 'ParkOps',
      icon: Building,
      description: 'Utility-Scale Operations',
      monthlyPrice: 299,
      annualPrice: 2990,
      features: ['Project Pipeline', 'SCADA Integration', 'EPC Coordination', 'Compliance Tracking', 'Investor Reports'],
      premiumFeatures: ['Advanced Analytics', 'Custom Dashboards', 'Multi-site Management', 'Enterprise Support']
    },
    {
      name: 'IrrigaPay',
      icon: Droplets,
      description: 'Solar Irrigation Billing',
      monthlyPrice: 79,
      annualPrice: 790,
      features: ['UPI Billing', 'Pump Scheduling', 'SMS Alerts', 'Offline Sync', 'Usage Reports'],
      premiumFeatures: ['Multi-language Support', 'Advanced Analytics', 'Custom Integrations', 'Priority Support']
    },
    {
      name: 'GridUnity',
      icon: Grid3X3,
      description: 'Community Solar Platform',
      monthlyPrice: 199,
      annualPrice: 1990,
      features: ['Energy Credits', 'Ownership Ledger', 'User Billing', 'Governance Tools', 'Basic Analytics'],
      premiumFeatures: ['Advanced Governance', 'Custom Workflows', 'API Access', 'Enterprise Support']
    },
    {
      name: 'RecycleLoop',
      icon: Recycle,
      description: 'Panel Lifecycle Tracking',
      monthlyPrice: 129,
      annualPrice: 1290,
      features: ['Lifecycle Tracking', 'Marketplace', 'Logistics Dashboard', 'QC Tools', 'ESG Reports'],
      premiumFeatures: ['Advanced Traceability', 'Custom Workflows', 'API Integration', 'Priority Support']
    },
    {
      name: 'ShareX',
      icon: Share2,
      description: 'MSME Solar Ownership',
      monthlyPrice: 179,
      annualPrice: 1790,
      features: ['Digital Ownership', 'Blockchain Ledger', 'Credit Scoring', 'Automated Payouts', 'MSME Analytics'],
      premiumFeatures: ['Advanced Analytics', 'Custom Integrations', 'White-label Solution', 'Dedicated Support']
    },
    {
      name: 'SmartOS',
      icon: Home,
      description: 'Smart Home Solar OS',
      monthlyPrice: 89,
      annualPrice: 890,
      features: ['Unified Control', 'AI Optimization', 'EV Scheduling', 'Voice Control', 'Lifestyle Reports'],
      premiumFeatures: ['Advanced AI', 'Custom Integrations', 'Premium Support', 'Beta Features']
    }
  ]

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <section className="bg-white py-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Modular Pricing for Every Solar Business
          </h1>
          <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
            Choose the SaaS products you need. Scale up or down as your business grows. No long-term commitments.
          </p>
          
          {/* Monthly/Annual Toggle */}
          <div className="flex items-center justify-center space-x-4 mb-12">
            <span className={`text-lg ${!isAnnual ? 'text-gray-900 font-semibold' : 'text-gray-500'}`}>
              Monthly
            </span>
            <button
              onClick={() => setIsAnnual(!isAnnual)}
              className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${
                isAnnual ? 'bg-green-600' : 'bg-gray-200'
              }`}
            >
              <span
                className={`inline-block h-4 w-4 transform rounded-full bg-white transition-transform ${
                  isAnnual ? 'translate-x-6' : 'translate-x-1'
                }`}
              />
            </button>
            <span className={`text-lg ${isAnnual ? 'text-gray-900 font-semibold' : 'text-gray-500'}`}>
              Annual
            </span>
            {isAnnual && (
              <span className="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
                Save 17%
              </span>
            )}
          </div>
        </div>
      </section>

      {/* Pricing Cards */}
      <section className="py-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {products.map((product, index) => {
              const IconComponent = product.icon
              const price = isAnnual ? product.annualPrice : product.monthlyPrice
              const period = isAnnual ? 'year' : 'month'
              
              return (
                <div
                  key={product.name}
                  className="bg-white rounded-2xl border border-gray-200 p-6 hover-lift animate-slide-up"
                  style={{ animationDelay: `${index * 100}ms` }}
                >
                  <div className="flex items-center space-x-3 mb-4">
                    <div className="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                      <IconComponent className="w-6 h-6 text-green-600" />
                    </div>
                    <div>
                      <h3 className="font-semibold text-gray-900">SolarSaaS {product.name}</h3>
                      <p className="text-sm text-gray-600">{product.description}</p>
                    </div>
                  </div>
                  
                  <div className="mb-6">
                    <div className="flex items-baseline">
                      <span className="text-3xl font-bold text-gray-900">${price}</span>
                      <span className="text-gray-600 ml-1">/{period}</span>
                    </div>
                    {isAnnual && (
                      <p className="text-sm text-green-600 mt-1">
                        Save ${(product.monthlyPrice * 12) - product.annualPrice} annually
                      </p>
                    )}
                  </div>

                  <div className="space-y-3 mb-6">
                    <h4 className="font-medium text-gray-900">Core Features:</h4>
                    {product.features.map((feature) => (
                      <div key={feature} className="flex items-center space-x-2">
                        <Check className="w-4 h-4 text-green-500 flex-shrink-0" />
                        <span className="text-sm text-gray-600">{feature}</span>
                      </div>
                    ))}
                  </div>

                  <div className="space-y-3 mb-8">
                    <h4 className="font-medium text-gray-900">Premium Add-ons:</h4>
                    {product.premiumFeatures.map((feature) => (
                      <div key={feature} className="flex items-center space-x-2">
                        <div className="w-4 h-4 border border-gray-300 rounded flex-shrink-0" />
                        <span className="text-sm text-gray-500">{feature}</span>
                      </div>
                    ))}
                  </div>

                  <Button className="w-full" variant="solar" asChild>
                    <Link href="/contact">
                      Get Started
                      <ArrowRight className="ml-2 w-4 h-4" />
                    </Link>
                  </Button>
                </div>
              )
            })}
          </div>
        </div>
      </section>

      {/* Enterprise Section */}
      <section className="py-20 bg-white">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
            Need a Custom Enterprise Solution?
          </h2>
          <p className="text-xl text-gray-600 mb-8">
            For large-scale deployments, custom integrations, or multi-product bundles, let's create a tailored package for your business.
          </p>
          
          <div className="bg-gray-50 rounded-2xl p-8 mb-8">
            <h3 className="text-xl font-semibold text-gray-900 mb-4">Enterprise Benefits</h3>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
              <div className="flex items-center space-x-2">
                <Check className="w-5 h-5 text-green-500" />
                <span>Volume discounts available</span>
              </div>
              <div className="flex items-center space-x-2">
                <Check className="w-5 h-5 text-green-500" />
                <span>Custom integrations included</span>
              </div>
              <div className="flex items-center space-x-2">
                <Check className="w-5 h-5 text-green-500" />
                <span>Dedicated account manager</span>
              </div>
              <div className="flex items-center space-x-2">
                <Check className="w-5 h-5 text-green-500" />
                <span>Priority support & training</span>
              </div>
              <div className="flex items-center space-x-2">
                <Check className="w-5 h-5 text-green-500" />
                <span>White-label options</span>
              </div>
              <div className="flex items-center space-x-2">
                <Check className="w-5 h-5 text-green-500" />
                <span>SLA guarantees</span>
              </div>
            </div>
          </div>

          <Button size="xl" variant="solar" asChild>
            <Link href="/contact">
              Request Enterprise Quote
              <ArrowRight className="ml-2 w-5 h-5" />
            </Link>
          </Button>
        </div>
      </section>

      {/* FAQ Section */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-gray-900 text-center mb-12">
            Frequently Asked Questions
          </h2>
          
          <div className="space-y-8">
            <div>
              <h3 className="text-lg font-semibold text-gray-900 mb-2">
                Can I use multiple SaaS products together?
              </h3>
              <p className="text-gray-600">
                Absolutely! Our products are designed to work seamlessly together. You can start with one product and add others as your business grows. We offer bundle discounts for multiple products.
              </p>
            </div>
            
            <div>
              <h3 className="text-lg font-semibold text-gray-900 mb-2">
                Is there a free trial available?
              </h3>
              <p className="text-gray-600">
                Yes, we offer a 14-day free trial for all our products. No credit card required. You can test all features and see how they fit your business needs.
              </p>
            </div>
            
            <div>
              <h3 className="text-lg font-semibold text-gray-900 mb-2">
                What's included in the premium add-ons?
              </h3>
              <p className="text-gray-600">
                Premium add-ons include advanced features like custom integrations, white-label options, advanced analytics, priority support, and dedicated account management. Pricing varies by product and requirements.
              </p>
            </div>
            
            <div>
              <h3 className="text-lg font-semibold text-gray-900 mb-2">
                Can I cancel anytime?
              </h3>
              <p className="text-gray-600">
                Yes, you can cancel your subscription at any time. There are no long-term contracts or cancellation fees. Your access continues until the end of your current billing period.
              </p>
            </div>
          </div>
        </div>
      </section>
    </div>
  )
} 