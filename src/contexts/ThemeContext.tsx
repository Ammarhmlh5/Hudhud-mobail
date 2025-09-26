import React, { createContext, useContext, useState, useEffect } from 'react';
import type { ReactNode } from 'react';

interface ThemeContextType {
  direction: 'rtl' | 'ltr';
  language: 'ar' | 'en';
  theme: 'light' | 'dark';
  setDirection: (direction: 'rtl' | 'ltr') => void;
  setLanguage: (language: 'ar' | 'en') => void;
  setTheme: (theme: 'light' | 'dark') => void;
  toggleDirection: () => void;
  toggleLanguage: () => void;
  toggleTheme: () => void;
}

const ThemeContext = createContext<ThemeContextType | undefined>(undefined);

interface ThemeProviderProps {
  children: ReactNode;
}

export const ThemeProvider: React.FC<ThemeProviderProps> = ({ children }) => {
  const [direction, setDirection] = useState<'rtl' | 'ltr'>('rtl');
  const [language, setLanguage] = useState<'ar' | 'en'>('ar');
  const [theme, setTheme] = useState<'light' | 'dark'>('light');

  useEffect(() => {
    // Load saved preferences
    const savedDirection = localStorage.getItem('direction') as 'rtl' | 'ltr';
    const savedLanguage = localStorage.getItem('language') as 'ar' | 'en';
    const savedTheme = localStorage.getItem('theme') as 'light' | 'dark';

    if (savedDirection) setDirection(savedDirection);
    if (savedLanguage) setLanguage(savedLanguage);
    if (savedTheme) setTheme(savedTheme);
  }, []);

  useEffect(() => {
    // Apply direction to document
    document.documentElement.setAttribute('dir', direction);
    document.documentElement.setAttribute('lang', language);
    
    // Apply theme class
    document.documentElement.classList.remove('light', 'dark');
    document.documentElement.classList.add(theme);
    
    // Save preferences
    localStorage.setItem('direction', direction);
    localStorage.setItem('language', language);
    localStorage.setItem('theme', theme);
  }, [direction, language, theme]);

  const handleSetDirection = (newDirection: 'rtl' | 'ltr') => {
    setDirection(newDirection);
  };

  const handleSetLanguage = (newLanguage: 'ar' | 'en') => {
    setLanguage(newLanguage);
    // Auto-adjust direction based on language
    if (newLanguage === 'ar') {
      setDirection('rtl');
    } else {
      setDirection('ltr');
    }
  };

  const handleSetTheme = (newTheme: 'light' | 'dark') => {
    setTheme(newTheme);
  };

  const toggleDirection = () => {
    setDirection(direction === 'rtl' ? 'ltr' : 'rtl');
  };

  const toggleLanguage = () => {
    const newLanguage = language === 'ar' ? 'en' : 'ar';
    handleSetLanguage(newLanguage);
  };

  const toggleTheme = () => {
    setTheme(theme === 'light' ? 'dark' : 'light');
  };

  const value: ThemeContextType = {
    direction,
    language,
    theme,
    setDirection: handleSetDirection,
    setLanguage: handleSetLanguage,
    setTheme: handleSetTheme,
    toggleDirection,
    toggleLanguage,
    toggleTheme,
  };

  return (
    <ThemeContext.Provider value={value}>
      {children}
    </ThemeContext.Provider>
  );
};

export const useTheme = (): ThemeContextType => {
  const context = useContext(ThemeContext);
  if (context === undefined) {
    throw new Error('useTheme must be used within a ThemeProvider');
  }
  return context;
};