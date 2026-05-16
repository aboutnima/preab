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

/** Mirrors App\Enums\GenderEnum */
export type Gender = 'male' | 'female';

export type EmployeeType = {
    id: number;
    company_id: number;
    first_name: string;
    last_name: string;
    email: string;
    gender: Gender | null;
    username: string | null;
    avatar: string | null;
    bio: string | null;
    is_active: boolean;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
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

