import Link from 'next/link'
import { Sun, Mail, Phone, MapPin } from 'lucide-react'

export function Footer() {
  const products = [
    { name: 'SalesPro', href: '/products/salespro' },
    { name: 'PPAFlow', href: '/products/ppaflow' },
    { name: 'ParkOps', href: '/products/parkops' },
    { name: 'IrrigaPay', href: '/products/irrigapay' },
    { name: 'GridUnity', href: '/products/gridunity' },
    { name: 'RecycleLoop', href: '/products/recycleloop' },
    { name: 'ShareX', href: '/products/sharex' },
    { name: 'SmartOS', href: '/products/smartos' },
  ]

  return (
    <footer className="bg-gray-900 text-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {/* Company Info */}
          <div className="space-y-4">
            <Link href="/" className="flex items-center space-x-2">
              <div className="w-8 h-8 solar-gradient rounded-lg flex items-center justify-center">
                <Sun className="w-5 h-5 text-white" />
              </div>
              <span className="text-xl font-bold">SolarSaaS Grid</span>
            </Link>
            <p className="text-gray-400 text-sm">
              Powering the solar revolution with purpose-built SaaS tools for every solar business model.
            </p>
            <div className="space-y-2 text-sm text-gray-400">
              <div className="flex items-center space-x-2">
                <Mail className="w-4 h-4" />
                <span>hello@solarsaasgrid.com</span>
              </div>
              <div className="flex items-center space-x-2">
                <Phone className="w-4 h-4" />
                <span>+1 (555) 123-4567</span>
              </div>
              <div className="flex items-center space-x-2">
                <MapPin className="w-4 h-4" />
                <span>San Francisco, CA</span>
              </div>
            </div>
          </div>

          {/* Products */}
          <div>
            <h3 className="font-semibold text-lg mb-4">Products</h3>
            <ul className="space-y-2">
              {products.map((product) => (
                <li key={product.name}>
                  <Link
                    href={product.href}
                    className="text-gray-400 hover:text-green-400 transition-colors text-sm"
                  >
                    SolarSaaS {product.name}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Company */}
          <div>
            <h3 className="font-semibold text-lg mb-4">Company</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/about" className="text-gray-400 hover:text-green-400 transition-colors">
                  About
                </Link>
              </li>
              <li>
                <Link href="/blog" className="text-gray-400 hover:text-green-400 transition-colors">
                  Blog
                </Link>
              </li>
              <li>
                <Link href="/careers" className="text-gray-400 hover:text-green-400 transition-colors">
                  Careers
                </Link>
              </li>
              <li>
                <Link href="/contact" className="text-gray-400 hover:text-green-400 transition-colors">
                  Contact
                </Link>
              </li>
            </ul>
          </div>

          {/* Support & Legal */}
          <div>
            <h3 className="font-semibold text-lg mb-4">Support & Legal</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/support" className="text-gray-400 hover:text-green-400 transition-colors">
                  Support
                </Link>
              </li>
              <li>
                <Link href="/documentation" className="text-gray-400 hover:text-green-400 transition-colors">
                  Documentation
                </Link>
              </li>
              <li>
                <Link href="/terms" className="text-gray-400 hover:text-green-400 transition-colors">
                  Terms of Service
                </Link>
              </li>
              <li>
                <Link href="/privacy" className="text-gray-400 hover:text-green-400 transition-colors">
                  Privacy Policy
                </Link>
              </li>
            </ul>
          </div>
        </div>

        <div className="border-t border-gray-800 mt-12 pt-8">
          <div className="flex flex-col md:flex-row justify-between items-center">
            <p className="text-gray-400 text-sm">
              © 2024 SolarSaaS Grid. All rights reserved.
            </p>
            <div className="flex space-x-6 mt-4 md:mt-0">
              <Link href="/terms" className="text-gray-400 hover:text-green-400 transition-colors text-sm">
                Terms
              </Link>
              <Link href="/privacy" className="text-gray-400 hover:text-green-400 transition-colors text-sm">
                Privacy
              </Link>
              <Link href="/cookies" className="text-gray-400 hover:text-green-400 transition-colors text-sm">
                Cookies
              </Link>
            </div>
          </div>
        </div>
      </div>
    </footer>
  )
} 