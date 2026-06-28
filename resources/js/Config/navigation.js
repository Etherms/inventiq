import {
    LayoutDashboard,
    Shield,
    FileText,
    Package,
    LayoutTemplate,
    AppWindow,
} from 'lucide-vue-next'

export const navigation = [
    {
        label: "Dashboard",
        href: "/dashboard",
        icon: LayoutDashboard,
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
        label: "Layouts",
        href: "/layouts",
        icon: LayoutTemplate,
    },
    {
        label: "Inventory Report",
        href: "/reports",
        icon: FileText,
    },
    {
        label: "Products",
        href: "/products",
        icon: Package,
    },
]