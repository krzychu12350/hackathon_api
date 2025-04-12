export type LinkedSocialAccount = {
    id: number;
    provider_id: string;
    provider_name: string;
    user_id: number;
    created_at?: string;
    updated_at?: string;
    user?: User;
};
export type Plant = {
    id: number;
    name: string;
    description?: string;
    preferred_water_amount: PlantWaterAmount;
    location: string;
    last_watering?: string;
    plant_category_id: number;
    user_id: number;
    created_at?: string;
    updated_at?: string;
    category?: PlantCategory;
    user?: User;
};
export type PlantCategory = {
    id: number;
    name: string;
    created_at?: string;
    updated_at?: string;
    plants?: Plant[];
};
export type User = {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    role: UserRole;
    created_at?: string;
    updated_at?: string;
    linked_social_accounts?: LinkedSocialAccount[];
    plants?: Plant[];
};
export enum PlantWaterAmount {
    SMALL = 0,
    NORMAL = 1,
    LARGE = 2
}
export enum UserRole {
    USER = "user",
    ADMIN = "admin"
}
