import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "./globals.css";
import { Navigation } from "@/components/navigation";
import { Footer } from "@/components/footer";
import { OrganizationStructuredData } from "@/components/seo-structured-data";

const inter = Inter({ subsets: ["latin"] });

export const metadata: Metadata = {
  title: {
    default: "SolarSaaS Grid - Powering the Solar Revolution",
    template: "%s | SolarSaaS Grid"
  },
  description: "Purpose-built SaaS tools for every solar business model. From CAPEX to Community Solar — one platform for all. Transform your solar business with our comprehensive suite of software solutions.",
  keywords: "solar SaaS, renewable energy software, solar management platform, solar CRM, utility-scale solar, community solar, solar operations, solar panel recycling, smart home solar",
  authors: [{ name: "SolarSaaS Grid Team" }],
  creator: "SolarSaaS Grid",
  publisher: "SolarSaaS Grid",
  robots: "index,follow",
  openGraph: {
    type: "website",
    locale: "en_US",
    url: "https://solarsaasgrid.com",
    siteName: "SolarSaaS Grid",
    title: "SolarSaaS Grid - Powering the Solar Revolution",
    description: "Purpose-built SaaS tools for every solar business model. From CAPEX to Community Solar — one platform for all.",
    images: [
      {
        url: "https://solarsaasgrid.com/og-image.jpg",
        width: 1200,
        height: 630,
        alt: "SolarSaaS Grid - Solar Software Solutions"
      }
    ]
  },
  twitter: {
    card: "summary_large_image",
    title: "SolarSaaS Grid - Powering the Solar Revolution",
    description: "Purpose-built SaaS tools for every solar business model. From CAPEX to Community Solar — one platform for all.",
    images: ["https://solarsaasgrid.com/og-image.jpg"],
    creator: "@solarsaasgrid"
  },
  verification: {
    google: "your-google-verification-code",
    yandex: "your-yandex-verification-code",
    yahoo: "your-yahoo-verification-code"
  },
  alternates: {
    canonical: "https://solarsaasgrid.com"
  },
  other: {
    "theme-color": "#16a34a",
    "apple-mobile-web-app-capable": "yes",
    "apple-mobile-web-app-status-bar-style": "default",
    "apple-mobile-web-app-title": "SolarSaaS Grid"
  }
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="en">
      <head>
        <OrganizationStructuredData />
        <link rel="icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
        <link rel="manifest" href="/site.webmanifest" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />
        <meta name="format-detection" content="telephone=no" />
      </head>
      <body className={inter.className}>
        <Navigation />
        <main className="min-h-screen">
          {children}
        </main>
        <Footer />
      </body>
    </html>
  );
}
