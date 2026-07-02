import {
    LayoutDashboard,
    PersonStanding,
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
        label: "Stock Movement",
        href: "/stock-movement",
        icon: FileText,
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
        label: "Users",
        href: "/users",
        icon: PersonStanding,
    },

]