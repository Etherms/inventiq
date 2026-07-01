import { Package, ArrowDownToLine, ArrowUpFromLine, CalendarDays } from 'lucide-vue-next'

export const stockStats = [
    {
        key: 'totalMovements',
        label: 'Total Movements',
        valueKey: 'totalMovements',
        description: 'All recorded transactions',
        icon: Package,
        href: '/stock-movement',
    },
    {
        key: 'stockIn',
        label: 'Stock In',
        valueKey: 'stockIn',
        description: 'Items added to inventory',
        icon: ArrowDownToLine,
        href: '/stock-movement?type=in',
    },
    {
        key: 'stockOut',
        label: 'Stock Out',
        valueKey: 'stockOut',
        description: 'Items deducted from inventory',
        icon: ArrowUpFromLine,
        href: '/stock-movement?type=out',
    },
    {
        key: 'todayMovements',
        label: "Today's Movements",
        valueKey: 'todayMovements',
        description: 'Transactions recorded today',
        icon: CalendarDays,
        href: '/stock-movement?date=today',
    },
]