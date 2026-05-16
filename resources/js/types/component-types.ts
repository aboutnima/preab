/**
 * Shared prop types for components and pages.
 * All types in this file must use the `Props` suffix.
 */

export type BreadcrumbItemProps = {
    label: string;
    href?: string;
};

export type NavItemProps = {
    label: string;
    href: string;
    /** HugeIcons icon array, e.g. `DashboardSquare01Icon` from `@hugeicons/core-free-icons` */
    icon: unknown;
};

