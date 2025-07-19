'use client'

import { useState } from 'react'
import { Button } from '@/components/ui/button'
import { 
  ArrowRight,
  CheckCircle,
  AlertCircle,
  Loader2
} from 'lucide-react'

interface FormData {
  name: string
  email: string
  company: string
  product: string
  message: string
  phone?: string
}

interface FormErrors {
  name?: string
  email?: string
  company?: string
  product?: string
}

export function EnhancedContactForm() {
  const [formData, setFormData] = useState<FormData>({
    name: '',
    email: '',
    company: '',
    product: '',
    message: '',
    phone: ''
  })
  
  const [errors, setErrors] = useState<FormErrors>({})
  const [isSubmitting, setIsSubmitting] = useState(false)
  const [isSubmitted, setIsSubmitted] = useState(false)

  const products = [
    'SolarSaaS SalesPro',
    'SolarSaaS PPAFlow',
    'SolarSaaS ParkOps',
    'SolarSaaS IrrigaPay',
    'SolarSaaS GridUnity',
    'SolarSaaS RecycleLoop',
    'SolarSaaS ShareX',
    'SolarSaaS SmartOS',
    'Multiple Products',
    'Enterprise Solution'
  ]

  const validateForm = (): boolean => {
    const newErrors: FormErrors = {}

    if (!formData.name.trim()) {
      newErrors.name = 'Name is required'
    }

    if (!formData.email.trim()) {
      newErrors.email = 'Email is required'
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
      newErrors.email = 'Please enter a valid email address'
    }

    if (!formData.company.trim()) {
      newErrors.company = 'Company name is required'
    }

    if (!formData.product) {
      newErrors.product = 'Please select a product'
    }

    setErrors(newErrors)
    return Object.keys(newErrors).length === 0
  }

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    
    if (!validateForm()) {
      return
    }

    setIsSubmitting(true)
    
    // Simulate API call
    try {
      await new Promise(resolve => setTimeout(resolve, 2000))
      console.log('Form submitted:', formData)
      setIsSubmitted(true)
    } catch (error) {
      console.error('Submission error:', error)
    } finally {
      setIsSubmitting(false)
    }
  }

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target
    setFormData(prev => ({
      ...prev,
      [name]: value
    }))
    
    // Clear error when user starts typing
    if (errors[name as keyof FormErrors]) {
      setErrors(prev => ({
        ...prev,
        [name]: undefined
      }))
    }
  }

  if (isSubmitted) {
    return (
      <div className="bg-white rounded-2xl border border-gray-200 p-8 text-center">
        <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
          <CheckCircle className="w-8 h-8 text-green-600" />
        </div>
        <h2 className="text-2xl font-bold text-gray-900 mb-4">
          Thank You!
        </h2>
        <p className="text-gray-600 mb-8">
          We&apos;ve received your demo request for <strong>{formData.product}</strong>. 
          Our team will contact you within 24 hours to schedule your personalized demo.
        </p>
        <Button 
          onClick={() => {
            setIsSubmitted(false)
            setFormData({
              name: '',
              email: '',
              company: '',
              product: '',
              message: '',
              phone: ''
            })
          }}
          variant="outline"
        >
          Submit Another Request
        </Button>
      </div>
    )
  }

  return (
    <div className="bg-white rounded-2xl border border-gray-200 p-8">
      <h2 className="text-2xl font-bold text-gray-900 mb-6">
        Request Your Demo
      </h2>
      
      <form onSubmit={handleSubmit} className="space-y-6">
        <div>
          <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-2">
            Full Name *
          </label>
          <input
            type="text"
            id="name"
            name="name"
            value={formData.name}
            onChange={handleChange}
            className={`w-full px-4 py-3 border rounded-lg transition-colors focus:ring-2 focus:ring-green-500 focus:border-transparent ${
              errors.name ? 'border-red-300 bg-red-50' : 'border-gray-300'
            }`}
            placeholder="Your full name"
          />
          {errors.name && (
            <div className="mt-1 flex items-center text-red-600 text-sm">
              <AlertCircle className="w-4 h-4 mr-1" />
              {errors.name}
            </div>
          )}
        </div>

        <div>
          <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
            Email Address *
          </label>
          <input
            type="email"
            id="email"
            name="email"
            value={formData.email}
            onChange={handleChange}
            className={`w-full px-4 py-3 border rounded-lg transition-colors focus:ring-2 focus:ring-green-500 focus:border-transparent ${
              errors.email ? 'border-red-300 bg-red-50' : 'border-gray-300'
            }`}
            placeholder="your.email@company.com"
          />
          {errors.email && (
            <div className="mt-1 flex items-center text-red-600 text-sm">
              <AlertCircle className="w-4 h-4 mr-1" />
              {errors.email}
            </div>
          )}
        </div>

        <div>
          <label htmlFor="company" className="block text-sm font-medium text-gray-700 mb-2">
            Company Name *
          </label>
          <input
            type="text"
            id="company"
            name="company"
            value={formData.company}
            onChange={handleChange}
            className={`w-full px-4 py-3 border rounded-lg transition-colors focus:ring-2 focus:ring-green-500 focus:border-transparent ${
              errors.company ? 'border-red-300 bg-red-50' : 'border-gray-300'
            }`}
            placeholder="Your company name"
          />
          {errors.company && (
            <div className="mt-1 flex items-center text-red-600 text-sm">
              <AlertCircle className="w-4 h-4 mr-1" />
              {errors.company}
            </div>
          )}
        </div>

        <div>
          <label htmlFor="phone" className="block text-sm font-medium text-gray-700 mb-2">
            Phone Number (Optional)
          </label>
          <input
            type="tel"
            id="phone"
            name="phone"
            value={formData.phone}
            onChange={handleChange}
            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
            placeholder="+1 (555) 123-4567"
          />
        </div>

        <div>
          <label htmlFor="product" className="block text-sm font-medium text-gray-700 mb-2">
            Which SaaS Product? *
          </label>
          <select
            id="product"
            name="product"
            value={formData.product}
            onChange={handleChange}
            className={`w-full px-4 py-3 border rounded-lg transition-colors focus:ring-2 focus:ring-green-500 focus:border-transparent ${
              errors.product ? 'border-red-300 bg-red-50' : 'border-gray-300'
            }`}
          >
            <option value="">Select a product</option>
            {products.map((product) => (
              <option key={product} value={product}>
                {product}
              </option>
            ))}
          </select>
          {errors.product && (
            <div className="mt-1 flex items-center text-red-600 text-sm">
              <AlertCircle className="w-4 h-4 mr-1" />
              {errors.product}
            </div>
          )}
        </div>

        <div>
          <label htmlFor="message" className="block text-sm font-medium text-gray-700 mb-2">
            Message
          </label>
          <textarea
            id="message"
            name="message"
            rows={4}
            value={formData.message}
            onChange={handleChange}
            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
            placeholder="Tell us about your business needs and what you&apos;d like to see in the demo..."
          />
        </div>

        <Button 
          type="submit" 
          size="xl" 
          variant="solar" 
          className="w-full"
          disabled={isSubmitting}
        >
          {isSubmitting ? (
            <>
              <Loader2 className="mr-2 w-5 h-5 animate-spin" />
              Submitting...
            </>
          ) : (
            <>
              Book a Free Demo
              <ArrowRight className="ml-2 w-5 h-5" />
            </>
          )}
        </Button>
      </form>

      <p className="text-sm text-gray-500 mt-4">
        * Required fields. We&apos;ll never share your information with third parties.
      </p>
    </div>
  )
} 