import {
    LayoutDashboard,
    Shield,
    FileText,
    Package,
    LayoutTemplate,
    AppWindow,
    Building2,
} from 'lucide-vue-next'

export const navigation = [
    {
        label: "Dashboard",
        href: "/dashboard",
        icon: LayoutDashboard,
    },
        {
        label: "Products",
        href: "/products",
        icon: Package,
    },
    {
        label: "Super Admin",
        href: "/admin",
        icon: Shield,
    },
    {
        label: "Categories",
        href: "/categories",
        icon: AppWindow,
    },
    {
        label: "Suppliers",
        href: "/suppliers",
        icon: Building2,
    },
    {
        label: "Layouts",
        href: "/layouts",
        icon: LayoutTemplate,
    },
    {
        label: "Inventory Report",
        href: "/reports",
        icon: FileText,
    },

]