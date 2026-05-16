import type { BreadcrumbItemProps } from '@/types/component-types';

export * from './component-types';

export type UserType = {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
};

export type CompanyType = {
    id: number;
    name: string;
    email: string;
    phone: string | null;
    address: string | null;
    logo: string | null;
    is_active: boolean;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
};

/**
 * Shared Inertia page props present on every authenticated company page.
 * Use as the generic: usePage<SharedPageProps>()
 */
export type SharedPageProps = {
    auth: CompanyType | null;
    breadcrumbs: BreadcrumbItemProps[];
};

