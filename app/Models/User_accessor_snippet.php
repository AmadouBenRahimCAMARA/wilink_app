
    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return ucfirst($this->prenom) . ' ' . strtoupper($this->nom);
    }
}
