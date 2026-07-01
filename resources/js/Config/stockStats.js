import {
    ArrowsRightLeftIcon,
    ArrowDownTrayIcon,
    ArrowUpTrayIcon,
    CalendarDaysIcon,
} from '@heroicons/vue/24/outline'

export const stockStats = [
    {
        key: 'totalMovements',
        label: 'Total Movements',
        valueKey: 'totalMovements',
        description: 'All stock transactions',
        filter: 'all',
        icon: ArrowsRightLeftIcon,
    },
    {
        key: 'stockIn',
        label: 'Stock In',
        valueKey: 'stockIn',
        description: 'Incoming stock transactions',
        filter: 'in',
        icon: ArrowDownTrayIcon,
    },
    {
        key: 'stockOut',
        label: 'Stock Out',
        valueKey: 'stockOut',
        description: 'Outgoing stock transactions',
        filter: 'out',
        icon: ArrowUpTrayIcon,
    },
    {
        key: 'todayMovements',
        label: "Today's Movements",
        valueKey: 'todayMovements',
        description: 'Transactions created today',
        filter: 'today',
        icon: CalendarDaysIcon,
    },
]