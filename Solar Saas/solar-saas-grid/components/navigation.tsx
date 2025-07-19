'use client'

import { useState } from 'react'
import Link from 'next/link'
import { Button } from '@/components/ui/button'
import { Menu, X, Sun, ChevronDown } from 'lucide-react'

export function Navigation() {
  const [isOpen, setIsOpen] = useState(false)
  const [isProductsOpen, setIsProductsOpen] = useState(false)

  const products = [
    { name: 'SalesPro', href: '/products/salespro', description: 'CRM & Sales Management' },
    { name: 'PPAFlow', href: '/products/ppaflow', description: 'PPA Lifecycle Management' },
    { name: 'ParkOps', href: '/products/parkops', description: 'Utility-Scale Operations' },
    { name: 'IrrigaPay', href: '/products/irrigapay', description: 'Solar Irrigation Billing' },
    { name: 'GridUnity', href: '/products/gridunity', description: 'Community Solar Platform' },
    { name: 'RecycleLoop', href: '/products/recycleloop', description: 'Panel Lifecycle Tracking' },
    { name: 'ShareX', href: '/products/sharex', description: 'MSME Solar Ownership' },
    { name: 'SmartOS', href: '/products/smartos', description: 'Smart Home Solar OS' },
  ]

  return (
    <nav className="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-16">
          {/* Logo */}
          <Link href="/" className="flex items-center space-x-2">
            <div className="w-8 h-8 solar-gradient rounded-lg flex items-center justify-center">
              <Sun className="w-5 h-5 text-white" />
            </div>
            <span className="text-xl font-bold text-gray-900">SolarSaaS Grid</span>
          </Link>

          {/* Desktop Navigation */}
          <div className="hidden md:flex items-center space-x-8">
            <div className="relative">
              <button
                onClick={() => setIsProductsOpen(!isProductsOpen)}
                className="flex items-center space-x-1 text-gray-700 hover:text-green-600 transition-colors"
              >
                <span>Products</span>
                <ChevronDown className="w-4 h-4" />
              </button>
              
              {isProductsOpen && (
                <div className="absolute top-full left-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                  <div className="grid grid-cols-1 gap-1">
                    {products.map((product) => (
                      <Link
                        key={product.name}
                        href={product.href}
                        className="px-4 py-3 hover:bg-gray-50 transition-colors"
                        onClick={() => setIsProductsOpen(false)}
                      >
                        <div className="font-medium text-gray-900">SolarSaaS {product.name}</div>
                        <div className="text-sm text-gray-500">{product.description}</div>
                      </Link>
                    ))}
                  </div>
                </div>
              )}
            </div>
            
            <Link href="/pricing" className="text-gray-700 hover:text-green-600 transition-colors">
              Pricing
            </Link>
            <Link href="/blog" className="text-gray-700 hover:text-green-600 transition-colors">
              Blog
            </Link>
            <Link href="/contact" className="text-gray-700 hover:text-green-600 transition-colors">
              Contact
            </Link>
          </div>

          {/* Desktop CTA */}
          <div className="hidden md:flex items-center space-x-4">
            <Button variant="outline" asChild>
              <Link href="/contact">Request Demo</Link>
            </Button>
          </div>

          {/* Mobile menu button */}
          <button
            onClick={() => setIsOpen(!isOpen)}
            className="md:hidden p-2 rounded-md text-gray-700 hover:text-green-600 hover:bg-gray-100"
          >
            {isOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
          </button>
        </div>

        {/* Mobile Navigation */}
        {isOpen && (
          <div className="md:hidden py-4 border-t border-gray-200">
            <div className="space-y-4">
              <div>
                <div className="font-medium text-gray-900 mb-2">Products</div>
                <div className="pl-4 space-y-2">
                  {products.map((product) => (
                    <Link
                      key={product.name}
                      href={product.href}
                      className="block text-gray-600 hover:text-green-600 transition-colors"
                      onClick={() => setIsOpen(false)}
                    >
                      SolarSaaS {product.name}
                    </Link>
                  ))}
                </div>
              </div>
              
              <Link
                href="/pricing"
                className="block text-gray-700 hover:text-green-600 transition-colors"
                onClick={() => setIsOpen(false)}
              >
                Pricing
              </Link>
              
              <Link
                href="/blog"
                className="block text-gray-700 hover:text-green-600 transition-colors"
                onClick={() => setIsOpen(false)}
              >
                Blog
              </Link>
              
              <Link
                href="/contact"
                className="block text-gray-700 hover:text-green-600 transition-colors"
                onClick={() => setIsOpen(false)}
              >
                Contact
              </Link>
              
              <div className="pt-4 border-t border-gray-200">
                <Button variant="solar" className="w-full" asChild>
                  <Link href="/contact">Request Demo</Link>
                </Button>
              </div>
            </div>
          </div>
        )}
      </div>
    </nav>
  )
} 