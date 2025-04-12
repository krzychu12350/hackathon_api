export type UpdatePlantRequest = {
    name?: string;
    description?: string;
    preferred_water_amount?: string;
    location?: string;
    last_watering?: string;
    plant_category_id?: string;
};
export type StorePlantRequest = {
    name: string;
    description?: string;
    preferred_water_amount: string;
    location: string;
    last_watering?: string;
    expected_humidity?: number;
    current_humidity?: number;
};
export type RegisterRequest = {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
};
export type LoginRequest = {
    email: string;
    password: string;
};
export type SocialRegisterRequest = {
    access_token: string;
    provider: string;
};
export type SocialLoginRequest = {
    access_token: string;
    provider: string;
};
